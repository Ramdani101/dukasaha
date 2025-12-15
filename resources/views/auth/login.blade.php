<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dukasaha</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        
        /* Pallete Color Variables */
        /* Primary     : #FEF3E2 (Cream Background)
           Secondary   : #FAB12F (Yellow/Orange)
           Secondary 2 : #FA812F (Orange)
           Secondary 3 : #DD0303 (Red)
        */
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex items-center justify-center p-1">

    <div class="w-full max-w-md">
        
        <div class="flex flex-col items-center relative z-10 -mb-9">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha logo" class="w-35 h-35 object-contain">
        </div>

        <div class="bg-white border-2 border-[#FA812F] rounded-[30px] px-8 pb-8 pt-12 shadow-sm">
            
            <h2 class="text-3xl font-montserrat font-bold text-center mb-8 bg-linear-to-r from-[#FA812F] to-[#DD0303] bg-clip-text text-transparent">
                Login
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6 text-sm text-center">
                    @foreach ($errors->all() as $error)
                        <span class="block">{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 text-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm text-[#FA812F] font-medium mb-2 ml-1">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="jonxxx@gmail.com" 
                           class="w-full px-4 py-3 rounded-2xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-400 text-gray-700 transition"
                           required>
                </div>

                <div class="mb-2">
                    <label for="password" class="block text-sm text-[#FA812F] font-medium mb-2 ml-1">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           placeholder="••••••••" 
                           class="w-full px-4 py-3 rounded-2xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-400 text-gray-700 transition"
                           required>
                </div>

                <div class="mb-8 ml-1 flex justify-between items-center">
                    <span class="text-xs text-gray-500">
                        Lupa Password? 
                        <a href="#" class="font-bold text-[#DD0303] hover:underline">Klik disini</a>
                    </span>
                </div>

                <div class="flex justify-center mb-6">
                    <button type="submit" class="w-full sm:w-auto text-white font-montserrat font-bold py-3 px-12 rounded-full shadow-md transition duration-300 transform hover:scale-105 active:scale-95 bg-linear-to-r from-[#FAB12F] to-[#FA812F]">
                        Sign In
                    </button>
                </div>

                <div class="text-center border-t border-gray-100 pt-4">
                    <p class="text-sm text-gray-600">
                        Dont' have an account yet? 
                        <a href="{{ route('register') }}" class="font-montserrat font-bold text-[#FA812F] hover:text-[#DD0303] hover:underline">
                            Sign Up
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>