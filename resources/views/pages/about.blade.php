<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="view-transition" content="same-origin">
    <title>About - Dukasaha</title>
    @vite('resources/css/app.css')
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        
        /* Custom curve */
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
<body class="bg-[#FEF3E2] min-h-screen flex flex-col overflow-x-hidden fade-in-up">

    <header class="relative w-full">
        <div class="bg-gradient-to-r from-[#FA812F] to-[#DD0303] h-24 w-full curve-header absolute top-0 z-0"></div>
        
        <nav class="relative z-10 flex justify-center space-x-10 pt-4">
            
            <a href="{{ route('about') }}" class="relative text-white font-bold text-lg">
                About
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-100"></span>
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

        <div class="relative z-10 flex justify-center mt-13">
            <a href="{{ route('landing') }}" class="hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha Logo" class="h-12 md:h-16 object-contain">
            </a>
        </div>
    </header>

    <main class="flex-grow flex flex-col justify-center max-w-6xl mx-auto px-6 py-20 w-full space-y-20 md:space-y-32">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            
            <div class="text-left">
                <h1 class="font-montserrat font-extrabold text-4xl md:text-5xl text-[#FA812F] leading-tight">
                    what is <br>
                    dukasaha?
                </h1>
            </div>

            <div class="text-left">
                <p class="text-[#F9A66C] text-lg md:text-2xl font-medium leading-relaxed">
                    dukasaha isn't just a place to receive 
                    anonymous messages; it’s a platform 
                    where you can chat with your 
                    admirers and see where the 
                    connection takes you.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            
            <div class="text-right order-2 md:order-1">
                <p class="text-[#F9A66C] text-lg md:text-2xl font-medium leading-relaxed">
                    We’re here to satisfy your curiosity 
                    about your anonymous senders—after 
                    all, one of them might just be your 
                    crush.
                </p>
            </div>

            <div class="text-right order-1 md:order-2">
                <h1 class="font-montserrat font-extrabold text-4xl md:text-5xl text-[#FA812F] leading-tight">
                    what our <br>
                    vision?
                </h1>
            </div>
        </div>

    </main>

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

</body>
</html>