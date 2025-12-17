<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Duka Saha</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex flex-col relative">

    <header class="bg-gradient-to-r from-[#FA812F] to-[#FAB12F] h-10 w-full flex items-center justify-between px-6 md:px-12 relative shadow-sm">
        
        <a href="{{ route('dashboard') }}" class="flex-shrink-0">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha Logo" class="h-8 md:h-20 object-contain"> 
        </a>

        <div class="absolute left-1/2 transform -translate-x-1/2">
            <span class="text-white font-light text-xl md:text-2xl font-poppins">setting</span>
        </div>

        <a href="{{ route('profile.edit') }}" class="flex-shrink-0 group">
            <img src="{{ asset('image/user-logo.svg') }}" alt="User Profile" class="h-8 md:h-9 w-8 md:w-9 object-contain group-hover:scale-110 transition-transform duration-300">
        </a>
    </header>

    <main class="flex-grow flex flex-col items-center pt-10 px-4 space-y-8">
        
        <div class="bg-gradient-to-r from-[#FA812F] to-[#FAB12F] backdrop-blur-sm p-8 rounded-[30px] shadow-lg w-full max-w-md text-center border border-orange-100">
            
            
            <h2 class="text-2xl font-montserrat font-bold text-white">{{ $user->username }}</h2>
            <p class="text-white mb-2">{{ $user->email }}</p>
            
            <div class="bg-orange-50 text-[#FA812F] px-4 py-2 rounded-full inline-block font-mono text-sm border border-[#FA812F]/20">
                @ {{ $user->username }}
            </div>

            @if (session('status'))
                <div class="mt-4 bg-green-100 text-green-700 p-3 rounded-xl text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mt-4 bg-red-100 text-red-700 p-3 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        <div class="w-full max-w-md space-y-4">
            
            <button onclick="openModal('usernameModal')" class="w-full bg-white hover:bg-orange-50 text-gray-700 font-semibold py-4 px-6 rounded-2xl shadow-sm border border-gray-200 flex justify-between items-center transition-all group">
                <div class="flex items-center gap-3">
                    <span class="bg-orange-100 p-2 rounded-lg text-orange-500">✎</span>
                    <span>Change Username</span>
                </div>
                <span class="text-gray-400 group-hover:translate-x-1 transition-transform">›</span>
            </button>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-white hover:bg-orange-50 text-gray-700 font-semibold py-4 px-6 rounded-2xl shadow-sm border border-gray-200 flex justify-between items-center transition-all group">
                    <div class="flex items-center gap-3">
                        <span class="bg-gray-100 p-2 rounded-lg text-gray-500">➔</span>
                        <span>Log Out</span>
                    </div>
                    <span class="text-gray-400 group-hover:translate-x-1 transition-transform">›</span>
                </button>
            </form>

            <button onclick="openModal('deleteModal')" class="w-full bg-white hover:bg-red-50 text-red-500 font-semibold py-4 px-6 rounded-2xl shadow-sm border border-red-100 flex justify-between items-center transition-all mt-8">
                <div class="flex items-center gap-3">
                    <span class="bg-red-100 p-2 rounded-lg text-red-500">🗑</span>
                    <span>Delete Account</span>
                </div>
            </button>
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

    <div id="usernameModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeModal('usernameModal')"></div>
        
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-sm px-4">
            <div class="bg-white rounded-[30px] p-6 shadow-2xl animate-bounce-in">
                <h3 class="font-montserrat font-bold text-xl text-gray-800 mb-2">Change Username</h3>
                <p class="text-sm text-gray-500 mb-6">Choose a unique username so people can find you.</p>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="relative mb-6">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">@</span>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required 
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-[#FA812F] focus:border-transparent text-gray-700 font-medium"
                            placeholder="new_username">
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('usernameModal')" class="flex-1 py-3 rounded-xl bg-gray-100 text-gray-600 font-semibold hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-3 rounded-xl bg-[#FA812F] text-white font-semibold hover:bg-[#e0701f] transition-colors shadow-lg shadow-orange-200">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('deleteModal')"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-sm px-4">
            <div class="bg-white rounded-[30px] p-6 shadow-2xl border-t-4 border-red-500">
                <div class="text-center mb-6">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">⚠️</span>
                    </div>
                    <h3 class="font-montserrat font-bold text-xl text-gray-800">Are you sure?</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        This action cannot be undone. All your messages and data will be permanently deleted.
                    </p>
                </div>

                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <input type="password" name="password" required 
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm"
                            placeholder="Enter password to confirm">
                         @if($errors->userDeletion->any())
                            <p class="text-red-500 text-xs mt-1">{{ $errors->userDeletion->first('password') }}</p>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('deleteModal')" class="flex-1 py-3 rounded-xl bg-gray-100 text-gray-600 font-semibold hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 transition-colors shadow-lg shadow-red-200">
                            Yes, Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Tampilkan modal delete otomatis jika ada error pada password saat delete
        @if($errors->userDeletion->any())
            openModal('deleteModal');
        @endif
    </script>

</body>
</html>