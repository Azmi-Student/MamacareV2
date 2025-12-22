<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mamacare Dashboard')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="{{ asset('images/logo-icon.png') }}" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- Tailwind + Config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#FF3EA5',
                    }
                },
            },
        }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- Custom Style --}}
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* --- STYLE LOADING SCREEN --- */
        #loading-screen {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            /* HALUS: Fade In & Fade Out sama-sama 1.2 detik */
            opacity: 1;
            visibility: visible;
            transition: opacity 1.2s ease-in-out, visibility 1.2s ease-in-out;
        }

        /* Class untuk sembunyikan (Fade Out) */
        .loader-hidden {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none;
        }

        /* Animasi Logo Muter */
        .spin-continuous {
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Progress Bar Fill */
        #progress-bar-fill {
            width: 0%;
            transition: width 0.2s ease-out;
            /* Bikin gerakan bar dari JS lebih halus */
        }

        /* Mengunci gaya teks agar tetap Pink saat Autofill Browser */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #FF3EA5 !important;
            /* Warna Pink Primary */
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
            /* Background tetap Putih */
            transition: background-color 5000s ease-in-out 0s;
            font-family: inherit !important;
        }

        /* Menangani state preview saat memilih data */
        input:autofill {
            color: #FF3EA5 !important;
        }
    </style>
</head>

<body class="bg-[#FFEFF8] text-gray-800 font-sans antialiased">

    {{-- LOADING SCREEN --}}
    <div id="loading-screen">
        {{-- Logo Muter --}}
        <img src="{{ asset('images/logo-icon.png') }}" alt="Loading..."
            class="w-16 h-16 object-contain spin-continuous mb-8">

        {{-- Progress Bar Container --}}
        <div class="w-64 h-2 bg-gray-100 rounded-full overflow-hidden relative shadow-inner">
            <div id="progress-bar-fill" class="h-full bg-[#FF3EA5] rounded-full"></div>
        </div>

        <p class="mt-4 text-xs font-semibold text-gray-400 tracking-[0.2em] animate-pulse uppercase">Memuat</p>
    </div>


    <div class="flex h-screen overflow-hidden">
        {{-- SIDEBAR --}}
        <div
            class="hidden lg:flex w-64 flex-col bg-white border-r-2 border-[#FF3EA5] h-full transition-all duration-300 z-40">
            @include('components.sidebar')
        </div>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            {{-- 
                HEADER MOBILE
                Logika: Tampil HANYA JIKA halaman anak TIDAK me-request untuk menyembunyikannya.
            --}}
            @if (!View::hasSection('hideMobileHeader'))
                <header
                    class="lg:hidden mx-4 mt-4 rounded-xl bg-white border-2 border-[#FF3EA5] shadow-[3px_3px_0px_0px_#ff90c8] h-14 flex items-center justify-between px-4 shrink-0 z-30 relative">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo-icon.png') }}" alt="Mamacare Logo"
                            class="block w-7 h-7 object-contain">
                        <span class="font-black text-lg text-[#FF3EA5] tracking-tight pl-1 uppercase">MamaCare</span>
                    </div>
                    <div class="flex items-center gap-3">
                        @include('components.header')
                    </div>
                </header>
            @endif

            {{-- MAIN AREA --}}
            {{-- 
               Kita juga bisa atur padding top dinamis. 
               Jika header di-hide (halaman chat), padding top (pt-6) kita hilangkan biar full screen.
               Jika header ada, pakai pt-6.
            --}}
            <main
                class="flex-1 overflow-x-hidden overflow-y-auto no-scrollbar p-4 pb-24 md:p-6 md:pb-24 lg:pb-6 
                {{ View::hasSection('hideMobileHeader') ? 'pt-0' : 'pt-6' }}">
                <div class="container mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- MOBILE NAVBAR --}}
    @if (!View::hasSection('hideMobileNav'))
        <div class="lg:hidden">
            @include('components.navbar-mobile')
        </div>
    @endif


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loader = document.getElementById('loading-screen');
            const progressFill = document.getElementById('progress-bar-fill');

            let progress = 0;
            let isPageLoaded = false;
            let simulationInterval;

            function runProgressSimulation() {
                clearInterval(simulationInterval);
                progress = 0;
                progressFill.style.width = '0%';

                // Mulai Fade In (Muncul) secara halus
                loader.classList.remove('loader-hidden');

                simulationInterval = setInterval(() => {
                    if (!isPageLoaded) {
                        // Jalan pelan ke 90%
                        if (progress < 90) {
                            progress += Math.random() * 1.5;
                        }
                    } else {
                        // Geber ke 100%
                        progress += 7;
                    }

                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(simulationInterval);

                        // Setelah bar 100%, tunggu sebentar baru Fade Out
                        setTimeout(() => {
                            loader.classList.add('loader-hidden');
                        }, 600);
                    }

                    progressFill.style.width = progress + '%';
                }, 40);
            }

            // A. Inisialisasi awal saat buka web
            runProgressSimulation();

            window.addEventListener('load', function() {
                isPageLoaded = true;
            });

            // B. Deteksi Klik Tombol/Link
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a, button[type="submit"], input[type="submit"]');

                if (target) {
                    const href = target.getAttribute('href');
                    const targetAttr = target.getAttribute('target');

                    if (
                        targetAttr === '_blank' ||
                        href === '#' ||
                        (href && href.startsWith('javascript')) ||
                        (href && href.startsWith('#'))
                    ) {
                        return;
                    }

                    // Reset status dan mulai animasi fade in
                    isPageLoaded = false;
                    runProgressSimulation();

                    // Safety timeout
                    setTimeout(() => {
                        isPageLoaded = true;
                    }, 6000);
                }
            });

            // C. Fix Browser Back
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    loader.classList.add('loader-hidden');
                }
            });
        });
    </script>
    <script>
        // Global configuration untuk fetch agar selalu bawa token CSRF
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    @include('components.donation-modal')
</body>

</html>
