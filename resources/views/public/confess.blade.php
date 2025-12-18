<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send message to {{ $user->username }}</title>
    @vite('resources/css/app.css')
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden">

    <main class="w-full max-w-2xl flex flex-col items-center space-y-6 z-10 px-4 sm:px-6">

        <h1 class="font-montserrat font-bold text-center text-lg sm:text-xl md:text-3xl text-[#FA812F] leading-tight">
            send {{ $user->username }} anonymous message!
        </h1>

        <form action="{{ route('confess.store') }}" method="POST" class="w-full flex flex-col items-center space-y-6 sm:space-y-8">
            @csrf
            
            <input type="hidden" name="username_target" value="{{ $user->username }}">

            <div class="w-full max-w-lg p-[4px] rounded-[28px] sm:rounded-[35px] bg-gradient-to-b from-[#FAB12F] via-[#FA812F] to-[#DD0303] shadow-sm">
                <textarea 
                    name="message" 
                    placeholder="type message here" 
                    aria-label="Message for {{ $user->username }}"
                    required
                    class="w-full h-48 sm:h-64 md:h-72 rounded-[26px] sm:rounded-[31px] bg-white p-4 sm:p-6 text-gray-700 placeholder-gray-400 focus:outline-none text-base sm:text-lg md:text-xl resize-none font-medium"></textarea>
            </div>

            <button type="submit" class="bg-black text-white font-montserrat font-extrabold text-lg sm:text-xl tracking-wider py-3 sm:py-4 px-8 sm:px-16 rounded-full hover:scale-105 transition-transform duration-300 shadow-lg cursor-pointer">
                SEND!
            </button>
        </form>

        <div class="h-6 sm:h-10 md:h-20"></div>

        <div class="flex flex-col items-center space-y-3">
            
            <a href="{{ route('landing') }}" class="font-montserrat font-bold text-white text-base sm:text-lg py-3 px-6 sm:px-8 rounded-full bg-gradient-to-r from-[#FA812F] to-[#DD0303] shadow-[0_4px_10px_rgba(221,3,3,0.4)] hover:shadow-[0_6px_14px_rgba(221,3,3,0.6)] transition-all hover:-translate-y-1">
                Get your own message
            </a>

            <a href="{{ route('terms') }}" class="text-gray-400 text-sm hover:text-[#FA812F] transition-colors">
                Terms & Service
            </a>
        </div>

    </main>

</body>
</html>