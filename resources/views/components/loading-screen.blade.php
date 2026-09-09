<style>
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

        /* HALUS: Fade In & Fade Out lebih cepat (0.6 detik) */
        opacity: 1;
        visibility: visible;
        transition: opacity 0.6s ease-in-out, visibility 0.6s ease-in-out;
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
</style>

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
                    }, 300);
                }

                progressFill.style.width = progress + '%';
            }, 40);
        }

        // A. Inisialisasi awal saat buka web
        runProgressSimulation();

        window.addEventListener('load', function() {
            isPageLoaded = true;
        });

        // B. Deteksi Klik pada Link (Abaikan tombol submit di sini)
        document.addEventListener('click', function(e) {
            const target = e.target.closest('a');

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

        // B2. Deteksi Submit Form (Hanya berjalan jika form valid)
        document.addEventListener('submit', function(e) {
            // Reset status dan mulai animasi fade in
            isPageLoaded = false;
            runProgressSimulation();

            // Safety timeout
            setTimeout(() => {
                isPageLoaded = true;
            }, 6000);
        });

        // C. Fix Browser Back
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                loader.classList.add('loader-hidden');
            }
        });
    });
</script>
