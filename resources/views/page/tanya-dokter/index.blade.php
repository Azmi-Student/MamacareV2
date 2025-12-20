@extends('layouts.app')

{{-- LOGIC: Sembunyikan Header Mobile bawaan Layout agar Chat Full Screen --}}
@section('hideMobileHeader', true)

@section('title', 'Tanya Dokter - Mamacare')

@section('content')
    <div class="min-h-screen bg-white text-[#FF3EA5] font-sans selection:bg-[#FF3EA5] selection:text-white"
         x-data="{ 
            view: 'grid', 
            activeDoctor: null,
            doctors: {{ json_encode($doctors) }}, // Data dari Controller
            messageInput: '',
            messages: [],
            chatInterval: null,
            
            // BUKA CHAT
            openChat(doc) {
                this.activeDoctor = doc;
                this.view = 'chat';
                this.messages = []; // Kosongkan tampilan awal
                
                // 1. Ambil Pesan Lama dari DB
                this.fetchMessages();

                // 2. Pasang Polling (Cek pesan baru tiap 3 detik)
                if (this.chatInterval) clearInterval(this.chatInterval);
                this.chatInterval = setInterval(() => {
                    this.fetchMessages();
                }, 3000);
            },

            // AMBIL PESAN DARI SERVER
            fetchMessages() {
                if(!this.activeDoctor) return;
                
                fetch(`/tanya-dokter/messages/${this.activeDoctor.id}`)
                    .then(res => res.json())
                    .then(data => {
                        // Cek apakah ada update data agar tidak flickering/scroll paksa
                        if (JSON.stringify(data) !== JSON.stringify(this.messages)) {
                            this.messages = data;
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    })
                    .catch(err => console.error(err));
            },

            // TUTUP CHAT
            closeChat() {
                this.view = 'grid';
                this.activeDoctor = null;
                if (this.chatInterval) clearInterval(this.chatInterval);
            },

            // KIRIM PESAN
            sendMessage() {
                if (this.messageInput.trim() === '') return;
                
                const textToSend = this.messageInput;
                const docId = this.activeDoctor.id;

                // Optimistic UI (Tampilin dulu biar cepet di layar user)
                // Note: time '...' menandakan sedang mengirim
                this.messages.push({ text: textToSend, sender: 'user', time: '...' });
                
                // Reset Input
                this.messageInput = '';
                this.$refs.input.style.height = 'auto'; 
                this.$nextTick(() => this.scrollToBottom());

                // Kirim ke Backend
                fetch('/tanya-dokter/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({
                        doctor_id: docId,
                        message: textToSend
                    })
                })
                .then(res => res.json())
                .then(data => {
                    // Refresh pesan untuk update status waktu/centang dari server
                    this.fetchMessages(); 
                })
                .catch(err => {
                    console.error('Gagal kirim:', err);
                    alert('Gagal mengirim pesan. Cek koneksi internet.');
                });
            },

            scrollToBottom() {
                const container = document.getElementById('chat-scroll-area');
                if(container) container.scrollTop = container.scrollHeight;
            },

            resize() {
                $refs.input.style.height = 'auto'; 
                $refs.input.style.height = $refs.input.scrollHeight + 'px';
            },

            sendAndReset() {
                if (this.messageInput.trim() === '') return;
                this.sendMessage();
            }
         }">

        {{-- =============================================================== --}}
        {{-- VIEW 1: GRID LIST DOKTER (TAMPILAN AWAL) --}}
        {{-- =============================================================== --}}
        <div x-show="view === 'grid'" x-transition.opacity.duration.300ms class="py-8 mb-20 md:mb-0">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                
                {{-- Header Page --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-6 border-b-2 border-dashed border-[#FF3EA5] pb-8">
                    <div>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest hover:underline mb-4">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Dashboard
                        </a>
                        <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tight leading-none">Tanya Dokter</h2>
                        <p class="text-xs font-bold mt-2 opacity-60">Konsultasi Full-Screen dengan Ahlinya.</p>
                    </div>
                    
                    {{-- Search --}}
                    <div class="w-full md:w-auto">
                        <div class="relative group">
                            <input type="text" placeholder="Cari Dokter..." 
                                class="w-full md:w-64 pl-4 pr-10 py-3 bg-white border-2 border-[#FF3EA5] rounded-xl font-bold text-sm text-[#FF3EA5] placeholder-[#FF3EA5]/40 focus:outline-none focus:shadow-[4px_4px_0px_0px_#FF3EA5] transition-all">
                            <div class="absolute right-3 top-3 text-[#FF3EA5]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                        </div>
                    </div>
                </div>

                {{-- Grid Dokter List --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="doc in doctors" :key="doc.id">
                        <div class="bg-white border-2 border-[#FF3EA5] rounded-[1.5rem] p-5 shadow-[4px_4px_0px_0px_#FF3EA5] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all flex flex-col h-full group relative">
                            
                            {{-- Profile Info --}}
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-14 h-14 rounded-full border-2 border-[#FF3EA5] p-0.5 bg-white shrink-0">
                                    {{-- Avatar (Inisial) --}}
                                    <div class="w-full h-full bg-pink-50 rounded-full flex items-center justify-center text-[#FF3EA5] font-black text-xl" x-text="doc.avatar"></div>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-black text-sm uppercase leading-tight truncate" x-text="doc.name"></h4>
                                    <p class="text-[10px] font-bold opacity-60 uppercase mt-0.5" x-text="doc.specialist"></p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-auto grid grid-cols-5 gap-2">
                                {{-- Tombol Chat In-App --}}
                                <button 
                                    @click="openChat(doc)"
                                    class="col-span-4 bg-[#FF3EA5] text-white border-2 border-[#FF3EA5] py-2 rounded-xl font-black uppercase text-xs shadow-[2px_2px_0px_0px_rgba(0,0,0,0.1)] hover:shadow-none hover:translate-x-[1px] hover:translate-y-[1px] transition-all flex items-center justify-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    Chat Sekarang
                                </button>

                                {{-- Tombol WA --}}
                                <a :href="'https://wa.me/?text=Halo ' + doc.name" target="_blank"
                                   class="col-span-1 bg-white text-[#FF3EA5] border-2 border-[#FF3EA5] rounded-xl flex items-center justify-center hover:bg-pink-50 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- =============================================================== --}}
        {{-- VIEW 2: FULL PAGE CHAT (LIVE) --}}
        {{-- Z-40: Menutupi Header, DI BAWAH Navbar Bawah --}}
        {{-- =============================================================== --}}
        <div x-show="view === 'chat'" x-transition:enter="transition ease-out duration-300"
             class="fixed inset-0 z-40 bg-pink-50 flex flex-col md:flex-row h-screen" 
             style="display: none;">
            
            {{-- SIDEBAR: List Dokter (Desktop Only) --}}
            <div class="hidden md:flex flex-col w-80 bg-white border-r-2 border-[#FF3EA5]">
                <div class="p-6 border-b-2 border-dashed border-[#FF3EA5]">
                    <div class="flex items-center gap-2 mb-4">
                        <button @click="closeChat" class="text-[#FF3EA5] hover:bg-pink-50 p-2 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </button>
                        <h3 class="font-black text-xl uppercase">Chat</h3>
                    </div>
                    <input type="text" placeholder="Cari..." class="w-full bg-pink-50 border-2 border-[#FF3EA5] rounded-xl px-4 py-2 text-xs font-bold text-[#FF3EA5] focus:outline-none placeholder-[#FF3EA5]/40">
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 space-y-2">
                    <template x-for="doc in doctors" :key="doc.id">
                        <div @click="openChat(doc)" 
                             class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all border-2"
                             :class="activeDoctor && activeDoctor.id === doc.id ? 'bg-[#FF3EA5] text-white border-[#FF3EA5] shadow-md' : 'bg-white text-[#FF3EA5] border-transparent hover:bg-pink-50'">
                            <div class="w-10 h-10 rounded-full border-2 border-current flex items-center justify-center font-black" :class="activeDoctor && activeDoctor.id === doc.id ? 'bg-white text-[#FF3EA5]' : 'bg-pink-50 text-[#FF3EA5]'">
                                <span x-text="doc.avatar"></span>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-xs uppercase truncate" x-text="doc.name"></h4>
                                <p class="text-[10px] opacity-70 truncate" x-text="doc.specialist"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- MAIN CHAT AREA --}}
            {{-- FIX: pb-24 (HP/Tablet ada navbar) -> lg:pb-0 (Desktop navbar hilang) --}}
            <div class="flex-1 flex flex-col bg-white h-full relative pb-24 lg:pb-0">
                
                {{-- Chat Header --}}
                <div class="h-16 md:h-20 bg-white border-b-2 border-[#FF3EA5] flex items-center justify-between px-4 md:px-6 shrink-0 shadow-sm z-10">
                    <div class="flex items-center gap-3 md:gap-4">
                        {{-- Back Button (Mobile Only) --}}
                        <button @click="closeChat" class="md:hidden text-[#FF3EA5] bg-pink-50 p-2 rounded-lg border-2 border-[#FF3EA5]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                        </button>

                        <div class="w-10 h-10 md:w-12 md:h-12 bg-[#FF3EA5] rounded-full flex items-center justify-center text-white font-black border-2 border-[#FF3EA5] text-lg">
                            <span x-text="activeDoctor ? activeDoctor.avatar : 'D'"></span>
                        </div>
                        <div>
                            <h4 class="font-black text-sm md:text-lg uppercase leading-tight" x-text="activeDoctor ? activeDoctor.name : ''"></h4>
                            <p class="text-[10px] font-bold text-[#FF3EA5] uppercase opacity-80" x-text="activeDoctor ? activeDoctor.specialist : ''"></p>
                        </div>
                    </div>
                </div>

                {{-- Chat Messages (Scroll Area) --}}
                <div id="chat-scroll-area" class="flex-1 overflow-y-auto p-4 md:p-6 bg-pink-50/30 space-y-4">
                    <template x-for="msg in messages">
                        <div class="flex flex-col w-full" :class="msg.sender === 'user' ? 'items-end' : 'items-start'">
                            {{-- Bubble --}}
                            <div class="max-w-[85%] md:max-w-[60%] px-5 py-3 rounded-2xl font-bold text-xs md:text-sm shadow-sm relative group"
                                 :class="msg.sender === 'user' 
                                    ? 'bg-[#FF3EA5] text-white rounded-tr-none' 
                                    : 'bg-white text-[#FF3EA5] border-2 border-[#FF3EA5] rounded-tl-none'">
                                <span x-text="msg.text" class="leading-relaxed"></span>
                            </div>
                            <span class="text-[9px] text-[#FF3EA5] mt-1.5 font-black uppercase opacity-60 px-1" x-text="msg.time"></span>
                        </div>
                    </template>
                </div>

                {{-- Chat Input Footer (Type Button + Textarea) --}}
                <div class="p-4 md:p-6 bg-white border-t-2 border-dashed border-[#FF3EA5] shrink-0">
                    <div class="flex items-end gap-3">
                        <button type="button" class="text-[#FF3EA5] p-2 mb-1 hover:bg-pink-50 rounded-full transition-colors hidden md:block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        </button>

                        <div class="flex-1 relative">
                            {{-- Textarea Auto-Grow --}}
                            <textarea 
                                x-model="messageInput"
                                x-ref="input"
                                rows="1"
                                @input="resize()"
                                @keydown.enter.exact.prevent="sendAndReset()"
                                class="w-full bg-pink-50 border-2 border-[#FF3EA5] rounded-xl px-5 py-3 text-sm font-bold text-[#FF3EA5] placeholder-[#FF3EA5]/50 focus:outline-none focus:shadow-[4px_4px_0px_0px_#FF3EA5] transition-all resize-none overflow-hidden max-h-32 block leading-relaxed"
                                placeholder="Ketik pesan..."
                            ></textarea>
                        </div>

                        {{-- Tombol Kirim: Type Button (Fix Loading) --}}
                        <button type="button" @click="sendAndReset()"
                            class="bg-[#FF3EA5] text-white p-3 md:px-6 md:py-3 rounded-xl border-2 border-[#FF3EA5] shadow-[3px_3px_0px_0px_rgba(0,0,0,0.1)] hover:shadow-none hover:translate-x-[1px] hover:translate-y-[1px] transition-all flex items-center gap-2 h-[46px]">
                            <span class="hidden md:inline font-black uppercase text-xs">Kirim</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection