<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Duka Saha</title>
    @vite('resources/css/app.css')
    
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        /* Custom scrollbar jika pesan banyak */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #FFF8E7;
        }
        ::-webkit-scrollbar-thumb {
            background: #FFA500;
            border-radius: 4px;
        }

        /* Animasi Slide Up Halus */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex flex-col justify-between fade-in-up">

    <header class="bg-gradient-to-r from-[#FA812F] to-[#FAB12F] h-10 w-full flex items-center justify-between px-6 md:px-12 relative shadow-sm">
        
        <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center h-full">
            <img src="{{ asset('image/logo_dukasaha.png') }}" 
                alt="Dukasaha Logo" 
                class="h-10 md:h-20 w-auto object-contain"> 
        </a>

        <div class="absolute left-1/2 transform -translate-x-1/2">
            <span class="text-white font-light text-xl md:text-2xl font-poppins">message</span>
        </div>

        <a href="{{ route('profile.edit') }}" class="flex-shrink-0 group flex items-center h-full">
            <img src="{{ asset('image/user-logo.svg') }}" 
                alt="User Profile" 
                class="h-7 w-7 md:h-8 md:w-8 object-contain group-hover:scale-110 transition-transform duration-300">
        </a>
    </header>

    <main class="flex-grow flex flex-col items-center py-10 px-4 relative">
        <div class="w-full max-w-3xl space-y-8">

            @forelse($confessions as $confession)
                <div class="relative group">
                    
                    @if($confession->is_read == 0) 
                        <div class="absolute -top-3 -left-3 w-6 h-6 bg-[#FF5F5F] rounded-full shadow-sm z-10 border-2 border-[#FFF8E7]"></div>
                    @endif

                    <a href="{{ route('confessions.show', $confession->id) }}" class="block">
                        <div class="bg-white border-[3px] border-[#FF9F43] rounded-2xl p-5 flex items-center shadow-sm hover:shadow-md transition-shadow cursor-pointer h-20">
                            
                            <div class="mr-6 text-[#FF9F43]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>

                            <h2 class="text-[#FF9F43] text-2xl font-bold truncate w-full">
                                {{ $confession->message }}
                            </h2>
                        </div>
                    </a>

                    <div class="text-right mt-1">
                        <span class="text-gray-400 text-sm font-medium">
                            {{ $confession->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-10">
                    <p class="text-xl">No messages yet.</p>
                </div>
            @endforelse

        </div>
    </main>

    <div class="fixed bottom-20 right-10 z-40">
        <a href="{{ route('dashboard')}}"> <img src="{{ asset('image/back-button.png') }}" alt="Back" class="w-10 h-10 hover:scale-105 transition-transform drop-shadow-lg">
        </a>
    </div>

    <footer class="bg-gradient-to-r from-[#FA812F] to-[#FAB12F] w-full py-1 px-6 mt-auto">
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8 text-white">
            
            <span class="font-light text-l">give ur feedback</span>

            <div class="flex items-center space-x-4">
                <a href="mailto:feedback@dukasaha.com" class="hover:opacity-80 hover:scale-110 transition-all">
                    <img src="{{ asset('image/email.svg') }}" alt="Email" class="h-6 w-6">
                </a>
                
                <a href="https://instagram.com/ramdan.wav" class="hover:opacity-80 hover:scale-110 transition-all">
                    <img src="{{ asset('image/instagram-logo.svg') }}" alt="Instagram" class="h-6 w-6">
                </a>

                <a href="https://web.facebook.com/ramdani.alhaytham/" class="hover:opacity-80 hover:scale-110 transition-all">
                    <img src="{{ asset('image/facebook-logo.svg') }}" alt="Facebook" class="h-6 w-6">
                </a>
            </div>

        </div>
    </footer>

</body>
</html>