<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room - Duka Saha</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#FFF8E7] flex flex-col h-screen relative overflow-hidden">

    <header class="bg-gradient-to-r from-[#FA812F] to-[#FAB12F] h-10 w-full flex items-center justify-between px-6 md:px-12 relative shadow-sm">
        
        <a href="{{ route('dashboard') }}" class="flex-shrink-0">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha Logo" class="h-8 md:h-20 object-contain"> 
        </a>

        <div class="absolute left-1/2 transform -translate-x-1/2">
            <span class="text-white font-light text-xl md:text-2xl font-poppins">chat</span>
        </div>

        <a href="{{ route('profile.edit') }}" class="flex-shrink-0 group">
            <img src="{{ asset('image/user-logo.svg') }}" alt="User Profile" class="h-8 md:h-9 w-8 md:w-9 object-contain group-hover:scale-110 transition-transform duration-300">
        </a>
    </header>

    <main class="flex-grow overflow-y-auto px-4 md:px-12 py-6 space-y-6 no-scrollbar pb-32" id="chat-container">
        
        <div class="w-full max-w-3xl mx-auto">
            <div class="w-full bg-gradient-to-r from-[#FA812F] to-[#DD0303] rounded-[30px] p-6 md:p-8 shadow-xl text-white relative transform transition-transform hover:scale-[1.01]">
                <p class="font-bold text-xl md:text-2xl leading-relaxed text-center font-montserrat drop-shadow-sm">
                    {{ $confession->message }}
                </p>
            </div>
        </div>

        <div class="flex items-center justify-center space-x-2 opacity-30 my-4">
            <div class="h-px w-12 bg-gray-400"></div>
            <span class="text-xs text-gray-500">Replies</span>
            <div class="h-px w-12 bg-gray-400"></div>
        </div>

        <div class="max-w-3xl mx-auto space-y-4">
            @foreach($confession->chats as $chat)
                
                @if($chat->sender_type == 'user')
                    <div class="flex justify-end w-full">
                        <div class="max-w-[85%] md:max-w-[70%] flex flex-col items-end">
                            <div class="bg-[#FF9F43] text-white px-5 py-3 rounded-tl-2xl rounded-tr-2xl rounded-bl-2xl shadow-md">
                                <p class="text-sm md:text-base leading-snug">{{ $chat->message }}</p>
                            </div>
                            <span class="text-[10px] text-gray-400 mt-1 mr-1">
                                {{ $chat->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                            </span>
                        </div>
                    </div>

                @else
                    <div class="flex justify-start w-full">
                        <div class="max-w-[85%] md:max-w-[70%] flex flex-col items-start">
                            <div class="bg-white text-gray-700 px-5 py-3 rounded-tl-2xl rounded-tr-2xl rounded-br-2xl shadow-sm border border-gray-100">
                                <p class="text-sm md:text-base leading-snug">{{ $chat->message }}</p>
                            </div>
                            <span class="text-[10px] text-gray-400 mt-1 ml-1">
                                {{ $chat->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>

        <div id="bottom-anchor" class="h-2"></div>
    </main>

    <div class="w-full max-w-2xl mx-auto mt-auto mb-6 sticky bottom-4 z-10">
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('chat.reply', $confession->id) }}" method="POST" class="relative w-full">
                @csrf
                <input type="text" 
                       name="message" 
                       placeholder="Reply to anonymous..." 
                       required
                       autocomplete="off"
                       class="w-full bg-white border border-gray-200 text-gray-700 rounded-full pl-6 pr-14 py-3 md:py-4 focus:outline-none focus:ring-2 focus:ring-[#FF9F43] shadow-lg transition-all">
                
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2  rounded-full transition-all hover:scale-105">
                    <img src="{{ asset('image/send.png') }}" alt="Send" class="h-5 w-5 md:h-6 md:w-6"> 
                </button>
            </form>
        </div>
    </div>

    <div class="fixed bottom-20 right-10 z-40">
        <a href="{{ route('messages.index')}}"> <img src="{{ asset('image/back-button.png') }}" alt="Back" class="w-10 h-10 hover:scale-105 transition-transform drop-shadow-lg">
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

    <script>
        const bottomAnchor = document.getElementById('bottom-anchor');
        // Scroll otomatis ke bawah saat load
        bottomAnchor.scrollIntoView({ behavior: "auto" });
    </script>

    <script>
        // Mobile menu toggle
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