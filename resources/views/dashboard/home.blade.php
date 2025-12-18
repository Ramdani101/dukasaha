<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="view-transition" content="same-origin">
    <title>Home - Dukasaha</title>
    @vite('resources/css/app.css')
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }

        /* Animasi Slide Up Halus */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Shadow khusus tombol Messages */
        .btn-shadow {
            box-shadow: 0px 4px 10px rgba(250, 177, 47, 0.5);
        }
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex flex-col justify-between fade-in-up">

    <header class="bg-gradient-to-r from-[#FA812F] to-[#FAB12F] h-10 w-full flex items-center justify-between px-6 md:px-12 relative shadow-sm">
        
        <a href="{{ route('dashboard') }}" class="flex-shrink-0">
            <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha Logo" class="h-8 md:h-20 object-contain"> 
        </a>

        <div class="absolute left-1/2 transform -translate-x-1/2">
            <span class="text-white font-light text-xl md:text-2xl font-poppins">home</span>
        </div>

        <a href="{{ route('profile.edit') }}" class="flex-shrink-0 group">
            <img src="{{ asset('image/user-logo.svg') }}" alt="User Profile" class="h-8 md:h-9 w-8 md:w-9 object-contain group-hover:scale-110 transition-transform duration-300">
        </a>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center px-4 space-y-6 text-center py-10">

        <h1 class="font-montserrat font-extrabold text-4xl md:text-4xl bg-gradient-to-r from-[#FA812F] to-[#DD0303] bg-clip-text text-transparent drop-shadow-sm">
            Hiii {{ Auth::user()->username ?? 'User' }}
        </h1>

        <div class="bg-gradient-to-r from-[#FAB12F] to-[#FA812F] text-white font-bold text-lg md:text-xl py-3 px-8 rounded-full shadow-md w-full max-w-md break-all">
            <span id="linkText">{{ url('/') }}/u/{{ Auth::user()->username ?? 'username' }}</span>
        </div>

        <button onclick="copyToClipboard()" class="border-2 border-[#FAB12F] text-[#FAB12F] bg-transparent hover:bg-[#FAB12F] hover:text-white transition-all duration-300 font-bold py-2 px-8 rounded-full text-lg cursor-pointer">
            copy link
        </button>

        <div class="h-2"></div>

        <p class="bg-gradient-to-r from-[#FA812F] to-[#DD0303] bg-clip-text text-transparent font-bold text-xl md:text-2xl">
            Go share it !
        </p>

        <div class="space-y-4">
            <p class="bg-gradient-to-r from-[#FA812F] to-[#DD0303] bg-clip-text text-transparent font-bold text-lg md:text-xl">
                and see their thoughts here
            </p>
            
            <a href="{{ route('messages.index') }}" class="inline-block bg-gradient-to-r from-[#FAB12F] to-[#FA812F] text-white font-extrabold text-2xl py-3 px-12 rounded-2xl btn-shadow hover:scale-105 hover:bg-[#e09e25] transition-all duration-300">
                MESSAGES
            </a>
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
        function copyToClipboard() {
            const linkText = document.getElementById("linkText").innerText;
            
            //cara modern (Clipboard API)
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(linkText).then(() => {
                    animateButton();
                }).catch(err => {
                    console.warn('Clipboard API gagal, mencoba fallback...', err);
                    fallbackCopyTextToClipboard(linkText);
                });
            } else {
                // Jika tidak support HTTPS/Clipboard API, pakai cara manual
                fallbackCopyTextToClipboard(linkText);
            }
        }

        // Fungsi Cadangan (Bekerja di HTTP & Browser Lama)
        function fallbackCopyTextToClipboard(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            
            // Pastikan elemen tidak terlihat mengganggu layout
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                if (successful) {
                    animateButton();
                } else {
                    alert("Gagal menyalin link secara otomatis.");
                }
            } catch (err) {
                console.error('Fallback error', err);
                alert("Browser tidak mendukung copy otomatis.");
            }

            document.body.removeChild(textArea);
        }

        // Fungsi untuk Mengubah Tampilan Tombol (Feedback Visual)
        function animateButton() {
            const btn = document.querySelector('button[onclick="copyToClipboard()"]');
            const originalText = "copy link"; // Teks asli disesuaikan manual agar aman
            
            // Ubah Teks dan Warna
            btn.innerText = "Copied!";
            btn.classList.add("bg-[#FAB12F]", "text-white");
            btn.classList.remove("text-[#FAB12F]", "bg-transparent");
            
            // Kembalikan ke Semula setelah 2 detik
            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.remove("bg-[#FAB12F]", "text-white");
                btn.classList.add("text-[#FAB12F]", "bg-transparent");
            }, 2000);
        }
    </script>

    <script>
        // Mobile menu toggle (no external dependency)
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