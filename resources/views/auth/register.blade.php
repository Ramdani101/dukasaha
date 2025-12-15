<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dukasaha</title>
    
    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        
        <div class="flex flex-col items-center relative z-10 -mb-9">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha logo" class="w-35 h-35 object-contain">
        </div>

        <div class="bg-white border-2 border-[#FA812F] rounded-[30px] px-8 pb-8 pt-12 shadow-sm">
            
            <h2 class="text-3xl font-montserrat font-bold text-center mb-6 bg-linear-to-r from-[#FA812F] to-[#DD0303] bg-clip-text text-transparent">
                Register
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4 text-sm text-center">
                    @foreach ($errors->all() as $error)
                        <span class="block">{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-sm text-[#FA812F] font-medium mb-1 ml-1 lowercase">username</label>
                    <input type="text" 
                           id="username" 
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="jondoe223" 
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-300 text-gray-700 transition"
                           required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm text-[#FA812F] font-medium mb-1 ml-1 lowercase">gmail</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="jonxxx@gmail.com" 
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-300 text-gray-700 transition"
                           required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm text-[#FA812F] font-medium mb-1 ml-1 lowercase">password</label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           placeholder="type here..." 
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-300 text-gray-700 transition"
                           required>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm text-[#FA812F] font-medium mb-1 ml-1 lowercase">password confirmation</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation"
                           placeholder="type here..." 
                           class="w-full px-4 py-2.5 rounded-2xl border border-[#FA812F] focus:outline-none focus:ring-2 focus:ring-[#FAB12F] placeholder-gray-300 text-gray-700 transition"
                           required>
                </div>

                <div class="text-center mb-6">
                    <p class="text-xs text-gray-500">
                        By clicking Sign Up, you agree to our Terms and Privacy Policy
                    </p>
                </div>

                <div class="flex justify-center mb-4">
                    <button type="submit" class="w-auto min-w-[150px] text-white font-montserrat font-bold py-3 px-8 rounded-full shadow-md transition duration-300 transform hover:scale-105 active:scale-95 bg-linear-to-r from-[#FAB12F] to-[#FA812F]">
                        Sign Up
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class=" font-bold text-[#FA812F] hover:text-[#DD0303] hover:underline">
                            Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>