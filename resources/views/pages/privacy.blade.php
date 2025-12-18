<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="view-transition" content="same-origin">
    <title>Privacy Policy - Dukasaha</title>
    @vite('resources/css/app.css')
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        
        /* Custom curve */
        .curve-header {
            border-bottom-left-radius: 50% 100%;
            border-bottom-right-radius: 50% 100%;
        }
        .curve-footer {
            border-top-left-radius: 50% 100%;
            border-top-right-radius: 50% 100%;
        }

        /* Custom Bullet Points Style */
        ul.custom-bullets li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.25rem;
        }
        ul.custom-bullets li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #F9A66C; 
            font-weight: bold;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#FEF3E2] min-h-screen flex flex-col overflow-x-hidden fade-in-up">

    <header class="relative w-full mb-10">
        <div class="bg-[#FAB12F] h-24 w-full curve-header absolute top-0 z-0"></div>
        
        <nav class="relative z-10 flex justify-center space-x-10 pt-4">
            
            <a href="{{ route('about') }}" class="relative text-white font-bold text-lg group">
                About
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="{{ route('safety') }}" class="relative text-white font-bold text-lg group">
                Safety
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="mailto:ramdani@dukasaha.com?subject=Halo%20Admin%20Dukasaha" class="relative text-white font-bold text-lg group">
                Contact Us
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>
        </nav>
        
        <div class="relative z-10 flex justify-center mt-13">
             <a href="{{ route('landing') }}" class="hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('image/logo_dukasaha.png') }}" alt="Dukasaha Logo" class="h-12 md:h-16 object-contain">
            </a>
        </div>
    </header>

    <main class="flex-grow w-full max-w-4xl mx-auto px-6 py-8">

        <div class="mb-10 text-left">
            <h1 class="font-montserrat font-extrabold text-3xl md:text-5xl text-[#FA812F] mb-3">
                Privacy Policy dukasaha
            </h1>
            <p class="text-[#F9A66C] text-sm md:text-base font-medium">
                Last updated : 16 December 2025
            </p>
        </div>

        <div class="text-[#F9A66C] font-medium text-base md:text-lg leading-relaxed mb-8">
            <p>
                At dukasaha.com, we take your privacy seriously. This Privacy Policy explains how we 
                collect, use, and protect your information when you use our anonymous messaging and 
                chat services.
            </p>
        </div>

        <div class="space-y-8 text-[#F9A66C] font-medium text-base md:text-lg">
            
            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    1. Information We Collect
                </h2>
                <ul class="custom-bullets">
                    <li>Account Information: If you create an account, we may collect your username, email address, and profile details.</li>
                    <li>Messages & Chat: We store the messages you send and receive to facilitate the chat functionality.</li>
                    <li>Technical Data: We automatically collect certain information such as your IP address, browser type, and device information to prevent spam and abuse.</li>
                    <li>Cookies: We use cookies to maintain your session and improve your user experience.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    2. How We Use Your Information
                </h2>
                <ul class="custom-bullets">
                    <li>To provide and maintain our messaging service.</li>
                    <li>To notify you about messages or activity on your account.</li>
                    <li>To monitor and prevent harassment, spam, and other malicious activities.</li>
                    <li>To improve our website's features and performance.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    3. Data Retention & Anonymity
                </h2>
                <ul class="custom-bullets">
                    <li>Sender Anonymity: We do not reveal the identity of an anonymous sender to the receiver unless required by law.</li>
                    <li>Data Deletion: You may request the deletion of your account or specific data by contacting us. However, some logs may be kept for a limited period for security purposes.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    4. Third-Party Services
                </h2>
                <p>
                    We may use third-party tools (such as Google Analytics or advertising partners). These 
                    services may collect information sent by your browser as part of a web page request.
                </p>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    5. Disclosure of Data
                </h2>
                <p class="mb-2">We will not sell or rent your personal information to third parties. We may only disclose your information if:</p>
                <ul class="custom-bullets">
                    <li>Required to do so by law or subpoena.</li>
                    <li>Necessary to protect the safety of our users or the public.</li>
                    <li>You provide explicit consent.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    6. Security
                </h2>
                <p>
                    We implement industry-standard security measures to protect your data. However, no 
                    method of transmission over the internet is 100% secure, and we cannot guarantee 
                    absolute security.
                </p>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    7. Changes to This Policy
                </h2>
                <p>
                    We may update our Privacy Policy from time to time. We will notify you of any changes by 
                    posting the new Privacy Policy on this page.
                </p>
            </div>

        </div>

    </main>

    <footer class="relative w-full mt-auto">
        <div class="bg-[#FAB12F] h-24 w-full curve-footer flex items-center justify-center space-x-10 pt-6">
            
            <a href="{{ route('terms') }}" class="relative text-white font-bold text-sm md:text-base group">
                Terms of Service
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="{{ route('privacy') }}" class="relative text-white font-bold text-sm md:text-base group">
                Privacy Policy
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-100"></span>
            </a>

        </div>
    </footer>

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