<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Duka Saha</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-[#FEF3E2] min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="bg-white rounded-lg sm:rounded-[30px] shadow-xl p-6 sm:p-8 w-full max-w-md sm:max-w-lg border border-orange-100 mx-3 sm:mx-0">
        <div class="text-center mb-4 sm:mb-6">
            <h1 class="font-montserrat font-bold text-lg sm:text-2xl text-[#FA812F]">New Password</h1>
            <p class="text-gray-400 text-xs sm:text-sm mt-2 font-poppins">Create a new secure password.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4 sm:space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-xs sm:text-sm text-gray-600 font-semibold mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                    class="w-full bg-gray-100 border border-gray-200 rounded-xl py-3 sm:py-4 px-3 sm:px-4 text-gray-500 cursor-not-allowed">
            </div>

            <div>
                <label for="password" class="block text-xs sm:text-sm text-gray-600 font-semibold mb-2">New Password</label>
                <input id="password" type="password" name="password" required 
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 sm:py-4 px-3 sm:px-4 focus:outline-none focus:ring-2 focus:ring-[#FA812F]"
                    placeholder="Min. 8 characters">
                @error('password')
                    <p role="alert" class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs sm:text-sm text-gray-600 font-semibold mb-2">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required 
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 sm:py-4 px-3 sm:px-4 focus:outline-none focus:ring-2 focus:ring-[#FA812F]"
                    placeholder="Type it again">
            </div>

            <button type="submit" class="w-full bg-[#FA812F] hover:bg-[#e0701f] text-white font-bold py-3 sm:py-4 px-6 rounded-xl shadow-lg shadow-orange-200 transition-all transform hover:scale-[1.02] mt-2 text-sm sm:text-base">
                Reset Password
            </button>
        </form>
    </div>

</body>
</html>