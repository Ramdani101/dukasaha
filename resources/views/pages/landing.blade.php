<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="view-transition" content="same-origin">
    <title>Dukasaha - Secret Messages</title>
    @vite('resources/css/app.css')
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        
        .curve-header {
            border-bottom-left-radius: 50% 100%;
            border-bottom-right-radius: 50% 100%;
        }
        .curve-footer {
            border-top-left-radius: 50% 100%;
            border-top-right-radius: 50% 100%;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#FEF3E2] overflow-x-hidden fade-in-up">

    <header class="relative w-full">
        <div class="bg-[#FAB12F] h-24 w-full curve-header absolute top-0 z-0"></div>
        
        <!-- Desktop nav -->
        <nav class="hidden md:flex relative z-10 justify-center space-x-10 pt-4" aria-label="Primary">
    
            <a href="{{ route('about') }}" class="relative text-white font-bold text-lg group">
                About
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="{{ route('safety') }}" class="relative text-white font-bold text-lg group">
                Safety
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="mailto:ramdani@dukasaha.com?subject=Halo%20Admin%20Dukasaha" class="relative text-white font-bold text-lg group">
                Contact Us
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

        </nav>

        <!-- Mobile nav: simple toggle -->
        <div class="md:hidden relative z-10 flex items-center justify-between px-4 pt-3">
            <a href="{{ route('landing') }}" class="hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha Logo" class="h-12 object-contain">
            </a>

            <button id="menu-toggle" aria-controls="mobile-menu" aria-expanded="false" class="p-2 rounded-md bg-white/10 text-white focus:outline-none focus:ring-2 focus:ring-white" aria-label="Open menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-transparent z-20 px-4">
            <div class="mt-2 bg-white/5 rounded-lg py-2 px-3 flex flex-col space-y-2">
                <a href="{{ route('about') }}" class="text-white font-semibold px-2 py-2 rounded hover:bg-white/10">About</a>
                <a href="{{ route('safety') }}" class="text-white font-semibold px-2 py-2 rounded hover:bg-white/10">Safety</a>
                <a href="mailto:ramdani@dukasaha.com?subject=Halo%20Admin%20Dukasaha" class="text-white font-semibold px-2 py-2 rounded hover:bg-white/10">Contact Us</a>
            </div>
        </div>

        <div class="relative z-10 flex justify-center mt-6 md:mt-13">
            <a href="{{ route('landing') }}" class="hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha Logo" class="hidden md:block h-16 object-contain">
            </a>
        </div>
    </header>

    <section class="relative max-w-6xl mx-auto px-4 pt-10 pb-20 mt-10 text-center">
        
        <h1 class="font-montserrat text-3xl md:text-4xl font-extrabold leading-tight bg-linear-to-r from-[#FA812F] to-[#DD0303] bg-clip-text text-transparent mb-15 drop-shadow-sm">
            Time to get a message <br>
            from your secret admirer
        </h1>

        <div class="relative z-20">
            <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-[#FAB12F] to-[#FA812F] text-white font-montserrat font-bold text-xl py-3 px-10  rounded-full shadow-lg transform transition hover:scale-105 active:scale-95">
                start here
            </a>
        </div>

        <img src="{{ asset('image/Confess Box 1.png') }}" alt="Box 1" class="hidden md:block absolute -top-5 left-20 w-40 rotate-[-6deg] animate-bounce-slow">
        
        <img src="{{ asset('image/emoji_bahagia.png') }}" alt="Wink" class="hidden md:block absolute top-10 right-32 w-24 rotate-[12deg]">

        <img src="{{ asset('image/emoji_bintang.png') }}" alt="Star" class="hidden md:block absolute bottom-0 left-32 w-24">

        <img src="{{ asset('image/Confess Box 2.png') }}" alt="Box 2" class="hidden md:block absolute bottom-5 right-20 w-40 rotate-[6deg] animate-bounce-slow">
    </section>

    <section class="relative w-full mt-20 mb-32 overflow-hidden">
        
        <div class="bg-gradient-to-r from-[#FAB12F] to-[#FA812F] w-[120%] -ml-[10%] rounded-[50%] py-40 md:py-60 relative flex flex-col items-center justify-center shadow-lg">
            
            <div class="w-full max-w-7xl px-4 relative flex flex-col items-center">

                <img src="{{ asset('image/emoji_kado.png') }}" alt="Gift" class="absolute top-30 left-50 md:left-[20%] w-15 md:w-32 rotate-[-12deg] animate-float">

                <img src="{{ asset('image/chat example 1.png') }}" alt="Chat 1" class="hidden md:block absolute left-10 top-0 transform -translate-y-1/2 w-64 lg:w-96 animate-wiggle">

                <h2 class="font-montserrat text-3xl md:text-4xl font-bold text-white text-center max-w-2xl leading-snug drop-shadow-md z-10">
                    Having a little chat <br>
                    with them
                </h2>

                <img src="{{ asset('image/chat example 2.png') }}" alt="Chat 2" class="hidden md:block absolute right-10 top-1/2 transform -translate-y-1/2 w-64 lg:w-96 animate-wiggle" style="animation-delay: 1.5s;">

                <img src="{{ asset('image/emoji_ultah.png') }}" alt="Party" class="absolute bottom-30 right-[15%] md:right-[20%] w-20 md:w-32 rotate-[12deg] animate-float" style="animation-delay: 1s;">
            
            </div>

        </div>

        <div class="md:hidden flex flex-col gap-6 -mt-20 relative z-10 items-center">
            <img src="{{ asset('image/chat example 1.png') }}" class="w-3/4 drop-shadow-lg transform rotate-[-3deg]">
            <img src="{{ asset('image/chat example 2.png') }}" class="w-3/4 drop-shadow-lg transform rotate-[3deg]">
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 pb-32 text-center">
        
        <h2 class="font-montserrat text-2xl md:text-4xl font-bold text-[#DD0303] mb-12">
            See what they’re thinking <br> about you
        </h2>

        <div class="flex flex-wrap justify-center gap-6 md:gap-15 items-center relative">
            
            <div class="transform rotate-[-3deg] hover:scale-110 transition duration-300">
                <img src="{{ asset('image/Confess Box 3.png') }}" alt="Box 3" class="w-32 md:w-48">
            </div>
            
            <div class="transform rotate-[2deg] hover:scale-110 transition duration-300 -mt-8 md:-mt-12">
                <img src="{{ asset('image/Confess Box 4.png') }}" alt="Box 4" class="w-32 md:w-48">
            </div>
            
            <div class="transform rotate-[-2deg] hover:scale-110 transition duration-300">
                <img src="{{ asset('image/Confess Box 5.png') }}" alt="Box 5" class="w-32 md:w-48">
            </div>

            <div class="w-full md:w-auto flex justify-center gap-6 md:gap-10 md:mt-8">
                <div class="transform rotate-[3deg] hover:scale-110 transition duration-300">
                    <img src="{{ asset('image/Confess Box 6.png') }}" alt="Box 6" class="w-32 md:w-48">
                </div>
                
                <div class="transform rotate-[-3deg] hover:scale-110 transition duration-300">
                    <img src="{{ asset('image/Confess Box 7.png') }}" alt="Box 7" class="w-32 md:w-48">
                </div>
            </div>
        </div>
    </section>

    <footer class="relative w-full mt-auto">
        <div class="bg-[#FAB12F] h-24 w-full curve-footer flex items-center justify-center space-x-10 pt-6">
            
            <a href="{{ route('terms') }}" class="relative text-white font-bold text-sm md:text-base group">
                Terms of Service
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="{{ route('privacy') }}" class="relative text-white font-bold text-sm md:text-base group">
                Privacy Policy
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>
        </div>
    </footer>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
        }
        .animate-wiggle {
            animation: wiggle 3s ease-in-out infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out forwards; /* forwards artinya berhenti di posisi akhir */
        }

        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%) rotate(-6deg); }
            50% { transform: translateY(5%) rotate(-6deg); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s infinite ease-in-out;
        }

        </style>

    <script>
        // Simple mobile menu toggle without any library
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('menu-toggle');
            const menu = document.getElementById('mobile-menu');
            if (!btn || !menu) return;

            btn.addEventListener('click', function () {
                const expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', String(!expanded));
                menu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>