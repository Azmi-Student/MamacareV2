@extends('layouts.app')

@section('title', 'Mama AI - Teman Curhat Mama')
@php $hideNavbar = true; @endphp
@section('content')
    <div class="container mx-auto max-w-5xl h-[calc(100dvh-100px)] md:h-[calc(100vh-120px)] flex flex-col px-4 pt-2 md:pt-4">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-4 md:mb-6 shrink-0">
            <a href="{{ route('dashboard') }}"
                class="bg-white border-2 md:border-4 border-[#FF3EA5] p-2 rounded-xl shadow-[3px_3px_0px_0px_#FF3EA5] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-[#FF3EA5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="4">
                    <path d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h2 class="text-xl md:text-2xl font-black text-[#FF3EA5] uppercase italic leading-none">Mama AI</h2>
                <p class="text-[9px] md:text-[10px] font-bold text-[#FF3EA5] opacity-60 uppercase tracking-widest">Asisten
                    Pribadi Mama</p>
            </div>
        </div>

        {{-- Chat Interface --}}
        <div x-data="chatSystem()"
            class="flex-1 bg-white border-4 border-[#FF3EA5] rounded-[2rem] md:rounded-[2.5rem] shadow-[8px_8px_0px_0px_#FF3EA5] md:shadow-[10px_10px_0px_0px_#FF3EA5] overflow-hidden flex flex-col relative mb-4">

            {{-- Area Pesan --}}
            <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 bg-pink-50/20" id="chat-window"
                style="scroll-behavior: smooth;">
                {{-- Welcome Message --}}
                <div class="flex justify-start">
                    <div
                        class="bg-white border-2 border-[#FF3EA5] p-3 md:p-4 rounded-2xl rounded-bl-none shadow-[4px_4px_0px_0px_#FF3EA5] max-w-[85%] text-xs md:text-sm font-bold text-[#FF3EA5] leading-relaxed">
                        Halo Mama! Ada yang bisa Mama AI bantu hari ini? Mau tanya soal nutrisi, gejala, atau sekadar
                        curhat? Mama AI siap dengerin! 😊
                    </div>
                </div>

                <template x-for="(chat, index) in messages" :key="index">
                    <div :class="chat.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                        <div :class="chat.role === 'user' ?
                            'bg-[#FF3EA5] text-white p-3 md:p-4 rounded-2xl rounded-br-none shadow-[-4px_4px_0px_0px_#ff90c8] border-2 border-[#FF3EA5]' :
                            'bg-white border-2 border-[#FF3EA5] text-[#FF3EA5] p-3 md:p-4 rounded-2xl rounded-bl-none shadow-[4px_4px_0px_0px_#FF3EA5]'"
                            class="max-w-[85%] md:max-w-[75%] text-xs md:text-sm font-bold leading-relaxed whitespace-pre-line break-words"
                            x-text="chat.text">
                        </div>
                    </div>
                </template>

                {{-- Loading State --}}
                <div x-show="isLoading" class="flex justify-start">
                    <div
                        class="bg-white border-2 border-[#FF3EA5] p-3 md:p-4 rounded-2xl rounded-bl-none shadow-[4px_4px_0px_0px_#FF3EA5] flex items-center gap-2">
                        <div class="flex gap-1">
                            <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-[#FF3EA5] rounded-full animate-bounce"
                                style="animation-delay: 0ms"></span>
                            <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-[#FF3EA5] rounded-full animate-bounce"
                                style="animation-delay: 200ms"></span>
                            <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-[#FF3EA5] rounded-full animate-bounce"
                                style="animation-delay: 400ms"></span>
                        </div>
                        <span
                            class="text-[10px] md:text-xs font-black text-[#FF3EA5] uppercase italic tracking-wider ml-1">Mama
                            AI mengetik</span>
                    </div>
                </div>
            </div>

            {{-- Input Area --}}
            <div class="p-3 md:p-4 bg-white border-t-4 border-[#FF3EA5] shrink-0">
                <form @submit.prevent="sendMessage" class="flex gap-2 md:gap-3">
                    <input type="text" x-model="userInput" @keydown.enter.prevent="sendMessage"
                        placeholder="Tanya Mama AI..."
                        class="flex-1 border-2 border-[#FF3EA5] p-3 md:p-4 rounded-xl font-bold text-[#FF3EA5] outline-none focus:bg-pink-50 transition-all text-xs md:text-sm placeholder:text-pink-300"
                        :disabled="isLoading">
                    <button type="submit" :disabled="isLoading || !userInput.trim()"
                        class="bg-[#FF3EA5] text-white p-3 md:p-4 rounded-xl shadow-[4px_4px_0px_0px_#ff90c8] active:shadow-none active:translate-x-1 active:translate-y-1 disabled:opacity-40 disabled:grayscale transition-all shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="4">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function chatSystem() {
            return {
                userInput: '',
                messages: [],
                isLoading: false,
                sendMessage() {
                    if (!this.userInput.trim() || this.isLoading) return;

                    const userText = this.userInput;

                    // --- TAMBAHAN: Simpan riwayat yang ada sekarang sebelum menambah pesan baru ---
                    const chatHistory = JSON.parse(JSON.stringify(this.messages));

                    this.messages.push({
                        role: 'user',
                        text: userText
                    });

                    this.userInput = '';
                    this.isLoading = true;

                    // Scroll instan setelah user kirim
                    this.scrollToBottom();

                    fetch("{{ route('mama.ai.send') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                message: userText,
                                // --- TAMBAHAN: Kirim riwayat chat agar AI ingat konteks ---
                                history: chatHistory
                            })
                        })  
                        .then(res => {
                            if (!res.ok) throw new Error();
                            return res.json();
                        })
                        .then(data => {
                            // 1. Ambil teks asli dari AI
                            let text = data.reply;

                            // 2. SAPU JAGAT: Hapus SEMUA karakter bintang (*) tanpa kecuali
                            // Kita pakai [ * ] di dalam bracket agar regex membacanya sebagai karakter murni
                            let cleanReply = text.replace(/[*]/g, '').trim();
                            this.messages.push({
                                role: 'ai',
                                text: data.reply
                            });
                        })
                        .catch(() => {
                            this.messages.push({
                                role: 'ai',
                                text: "Maaf Ma, koneksi lagi kurang stabil. Coba tanya lagi ya!"
                            });
                        })
                        .finally(() => {
                            this.isLoading = false;
                            this.scrollToBottom();
                        });
                },
                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('chat-window');
                        el.scrollTo({
                            top: el.scrollHeight,
                            behavior: 'smooth'
                        });
                    });
                }
            }
        }
    </script>
@endsection
