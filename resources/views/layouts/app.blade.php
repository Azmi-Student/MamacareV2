<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mamacare Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

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

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-[#FFEFF8] text-gray-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <div class="hidden lg:flex w-64 flex-col bg-white border-r border-gray-200 h-full transition-all duration-300">
            @include('components.sidebar')
        </div>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <header
                class="bg-white shadow-sm h-16 flex items-center justify-between lg:justify-end px-4 lg:px-6 border-b border-gray-200 shrink-0">

                <div class="lg:hidden flex items-center gap-2">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="Mamacare Logo"
                        class="block w-8 h-8 object-contain">
                    <span class="font-extrabold text-xl text-[#FF3EA5] tracking-tight pl-1">MamaCare</span>
                </div>

                <div class="flex items-center gap-4">
                    @include('components.header')
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 pb-24 md:p-6 md:pb-24 lg:pb-6">
                <div class="container mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>

        </div>

    </div>

    <div class="lg:hidden">
        @include('components.navbar-mobile')
    </div>

</body>

</html>
