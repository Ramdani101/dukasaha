<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Dukasaha</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#FFF8E7] flex flex-col min-h-screen">

    <header class="bg-gradient-to-r from-[#FA812F] to-[#FAB12F] h-12 sm:h-14 w-full flex items-center justify-between px-4 sm:px-6 md:px-12 relative shadow-sm">
        
        <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center h-full">
            <img src="{{ asset('image/logo_dukasaha.png') }}" 
                alt="Dukasaha Logo" 
                class="h-8 sm:h-10 md:h-20 w-auto object-contain"> 
        </a>

        <div class="absolute left-1/2 transform -translate-x-1/2">
            <span class="text-white font-light text-lg sm:text-xl md:text-2xl font-poppins">chat</span>
        </div>
    </header>

    <main class="flex-grow flex flex-col items-center w-full max-w-4xl mx-auto px-4 sm:px-6 pt-6 sm:pt-8 pb-4 relative">

        <div class="w-full max-w-3xl mx-auto mb-5">
            <div class="w-full bg-gradient-to-r from-[#FA812F] to-[#DD0303] rounded-lg sm:rounded-[30px] p-4 sm:p-6 md:p-8 shadow-xl text-white relative transform transition-transform hover:scale-[1.01]">
                <p class="font-bold text-lg sm:text-xl md:text-2xl leading-relaxed text-center font-montserrat drop-shadow-sm">
                    {{ $confession->message }}
                </p>
            </div>
        </div>

        <div class="w-full max-w-2xl flex flex-col space-y-4 mb-24 w-full">
            
            @forelse($confession->chats as $chat)
                {{-- LOGIKA: 'guest' = Saya (Kanan), 'user' = Pemilik Akun (Kiri) --}}
                
                @if($chat->sender_type == 'guest')
                    <div class="flex justify-end w-full px-2">
                        <div class="max-w-[90%] sm:max-w-[85%] md:max-w-[70%] flex flex-col items-end">
                            <div class="bg-[#FF9F43] text-white px-4 py-3 rounded-tl-2xl rounded-tr-2xl rounded-bl-2xl shadow-md">
                                <p class="text-sm sm:text-base md:text-base leading-snug">{{ $chat->message }}</p>
                            </div>
                            <span class="text-[11px] text-gray-400 mt-1 mr-1">
                                {{ $chat->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                            </span>
                        </div>
                    </div>

                @else
                    <div class="flex justify-start w-full px-2">
                        <div class="max-w-[90%] sm:max-w-[85%] md:max-w-[70%] flex flex-col items-start">
                            <div class="bg-white text-gray-700 px-4 py-3 rounded-tl-2xl rounded-tr-2xl rounded-br-2xl shadow-sm border border-gray-100">
                                <p class="text-sm sm:text-base md:text-base leading-snug">{{ $chat->message }}</p>
                            </div>
                            <span class="text-[11px] text-gray-400 mt-1 ml-1">
                                {{ $chat->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endif

            @empty
                <p class="text-center text-gray-400 text-sm italic mt-4">No replies yet. Start the conversation!</p>
            @endforelse

        </div>

        <div class="w-full max-w-2xl mx-auto mt-auto mb-6 sticky bottom-4 z-10 px-2 sm:px-0">
            <form action="{{ route('chat.guest.reply', $confession->guest_token) }}" method="POST" class="relative flex items-center">
                @csrf
                
                <input type="text" 
                       name="message" 
                       aria-label="Reply message"
                       placeholder="Type here..." 
                       required
                       autocomplete="off"
                       class="w-full bg-white border border-gray-200 text-gray-700 rounded-full pl-4 sm:pl-6 pr-14 py-3 sm:py-4 focus:outline-none focus:ring-2 focus:ring-[#FF9F43] shadow-lg transition-all">

                <button type="submit" class="absolute right-2 sm:right-3 top-1/2 transform -translate-y-1/2 p-3 sm:p-3 rounded-full bg-[#FF9F43] text-white transition-all hover:scale-105">
                    <img src="{{ asset('image/send.png') }}" alt="Send" class="h-5 w-5 sm:h-6 sm:w-6"> 
                </button>
            </form>
        </div>

    </main>

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.scrollTo(0, document.body.scrollHeight);
        });
    </script>

</body>
</html>