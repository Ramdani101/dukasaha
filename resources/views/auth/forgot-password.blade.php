<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Duka Saha</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-[#FEF3E2] min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8">

    <!-- Container: responsive padding and max widths for mobile/tablet/desktop -->
    <div class="bg-white rounded-lg sm:rounded-[30px] shadow-xl p-6 sm:p-8 w-full max-w-md sm:max-w-lg border border-orange-100 mx-3 sm:mx-0">
        <div class="text-center mb-4 sm:mb-6">
            <h1 class="font-montserrat font-bold text-lg sm:text-2xl text-[#FA812F]">Forgot Password?</h1>
            <p class="text-gray-400 text-xs sm:text-sm mt-2 font-poppins">Don't worry! Just enter your email and we'll send a link to reset it.</p>
        </div>

        @if (session('status'))
            <div role="status" aria-live="polite" class="bg-green-100 text-green-700 p-3 rounded-xl text-sm mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4 sm:space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-gray-600 font-semibold mb-2 ml-1 text-xs sm:text-sm">Email Address</label>
                <input id="email" type="email" name="email" autocomplete="email" inputmode="email" required 
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 sm:py-4 px-3 sm:px-4 focus:outline-none focus:ring-2 focus:ring-[#FA812F] transition-all"
                    placeholder="youremail@example.com">
                @error('email')
                    <p role="alert" class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#FA812F] hover:bg-[#e0701f] text-white font-bold py-3 sm:py-4 px-6 rounded-xl shadow-lg shadow-orange-200 transition-all transform hover:scale-[1.02] text-sm sm:text-base">
                Send Reset Link
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-gray-400 text-sm hover:text-[#FA812F] transition-colors">
                ← Back to Login
            </a>
        </div>
    </div>

</body>
</html>