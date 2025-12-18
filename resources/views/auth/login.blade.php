<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dukasaha</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="w-full max-w-md sm:max-w-lg mx-3 sm:mx-0">
        
        <div class="flex flex-col items-center relative z-10 -mb-8">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha logo" class="w-28 h-28 sm:w-32 sm:h-32 object-contain">
        </div>

        <div class="bg-white border-2 border-[#FA812F] rounded-lg sm:rounded-[30px] px-6 sm:px-8 pb-6 sm:pb-8 pt-8 sm:pt-12 shadow-sm">
            
            <h2 class="text-xl sm:text-3xl font-montserrat font-bold text-center mb-6 sm:mb-8 bg-gradient-to-r from-[#FA812F] to-[#DD0303] bg-clip-text text-transparent">
                Login
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm text-center">
                    @foreach ($errors->all() as $error)
                        <span class="block">{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs sm:text-sm text-[#FA812F] font-medium mb-2">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="jonxxx@gmail.com" 
                           class="w-full px-3 sm:px-4 py-3 sm:py-4 rounded-xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-400 text-gray-700 transition"
                           required>
                </div>

                <div>
                    <label for="password" class="block text-xs sm:text-sm text-[#FA812F] font-medium mb-2">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           placeholder="••••••••" 
                           class="w-full px-3 sm:px-4 py-3 sm:py-4 rounded-xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-400 text-gray-700 transition"
                           required>
                </div>

                <div class="flex items-center justify-between text-xs sm:text-sm text-gray-500 mt-1">
                    <div>
                        <a href="{{route('password.request')}}" class="font-bold text-[#DD0303] hover:underline">Forgot your password?</a>
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="w-full sm:w-auto block text-white font-montserrat font-bold py-3 sm:py-3 px-6 sm:px-12 rounded-full shadow-md transition duration-300 transform hover:scale-105 active:scale-95 bg-gradient-to-r from-[#FAB12F] to-[#FA812F]">
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