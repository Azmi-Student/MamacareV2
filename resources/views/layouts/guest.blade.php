<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mamacare')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Tailwind + Config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: { primary: '#FF3EA5' }
                },
            },
        }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- Style Loading (Sama seperti App Blade Mama) --}}
    <style>
        #loading-screen {
            position: fixed; inset: 0; z-index: 9999;
            background-color: white; display: flex;
            flex-direction: column; align-items: center; justify-content: center;
            opacity: 1; visibility: visible;
            transition: opacity 1.2s ease-in-out, visibility 1.2s ease-in-out;
        }
        .loader-hidden { opacity: 0 !important; visibility: hidden !important; pointer-events: none; }
        .spin-continuous { animation: spin 1.5s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        #progress-bar-fill { width: 0%; transition: width 0.2s ease-out; }

        /* 1. Mengatur teks saat preview & setelah dipilih (Autofill) */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        /* Memaksa warna teks tetap Pink Primary */
        -webkit-text-fill-color: #FF3EA5 !important; 
        /* Memaksa background tetap putih (menghapus warna kuning browser) */
        -webkit-box-shadow: 0 0 0px 1000px white inset !important;
        /* Memastikan font-weight mengikuti desain Mama */
        font-weight: 700 !important;
    }

    /* 2. Mengatur font saat kursor menyorot pilihan autofill (Preview State) */
    input:autofill {
        color: #FF3EA5 !important;
    }

    /* 3. Tambahan khusus untuk beberapa browser agar transisinya halus */
    input::-webkit-contacts-auto-fill-button {
        background-color: #FF3EA5;
    }
    </style>
</head>
<body class="bg-white text-gray-800 font-sans antialiased overflow-x-hidden">

    {{-- LOADING SCREEN --}}
    <div id="loading-screen">
        <img src="{{ asset('images/logo-icon.png') }}" alt="Loading..." class="w-16 h-16 object-contain spin-continuous mb-8">
        <div class="w-64 h-2 bg-gray-100 rounded-full overflow-hidden relative shadow-inner">
            <div id="progress-bar-fill" class="h-full bg-[#FF3EA5] rounded-full"></div>
        </div>
        <p class="mt-4 text-xs font-semibold text-gray-400 tracking-[0.2em] animate-pulse uppercase">Memuat</p>
    </div>

    {{-- TEMPAT KONTEN --}}
    <div class="min-h-screen flex flex-col lg:flex-row overflow-hidden">
        @yield('content')
    </div>

    {{-- Script Loading --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loader = document.getElementById('loading-screen');
            const progressFill = document.getElementById('progress-bar-fill');
            let progress = 0; let isPageLoaded = false;
            function runProgressSimulation() {
                loader.classList.remove('loader-hidden');
                let interval = setInterval(() => {
                    if (!isPageLoaded) { if (progress < 90) progress += Math.random() * 2; } 
                    else { progress += 10; }
                    if (progress >= 100) {
                        progress = 100; clearInterval(interval);
                        setTimeout(() => { loader.classList.add('loader-hidden'); }, 600);
                    }
                    progressFill.style.width = progress + '%';
                }, 50);
            }
            runProgressSimulation();
            window.addEventListener('load', () => { isPageLoaded = true; });
        });
    </script>
</body>
</html>