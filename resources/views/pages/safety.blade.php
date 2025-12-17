<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="view-transition" content="same-origin">
    <title>Safety - Dukasaha</title>
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
            margin-bottom: 0.5rem;
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

    <header class="relative w-full">
        <div class="bg-[#FAB12F] h-24 w-full curve-header absolute top-0 z-0"></div>
        
        <nav class="relative z-10 flex justify-center space-x-10 pt-4">
            
            <a href="{{ route('about') }}" class="relative text-white font-bold text-lg group">
                About
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="{{ route('safety') }}" class="relative text-white font-bold text-lg">
                Safety
                <span class="absolute left-1/2 -translate-x-1/2 -bottom-2 w-1.5 h-1.5 bg-white rounded-full opacity-100"></span>
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

    <main class="flex-grow w-full max-w-5xl mx-auto px-6 py-12">

        <div class="text-center mb-12">
            <h1 class="font-montserrat font-extrabold text-3xl md:text-5xl text-[#FA812F] mb-6">
                Your safety is our priority
            </h1>
            <p class="text-[#F9A66C] font-medium text-base md:text-lg leading-relaxed max-w-4xl mx-auto">
                At Dukasaha, we are committed to providing a secure environment for our community. 
                However, safety is a shared responsibility. Here are some essential tips to keep your 
                account and transactions safe.
            </p>
        </div>

        <div class="space-y-10 text-[#F9A66C] font-medium text-base md:text-lg">
            
            <div>
                <h2 class="font-montserrat font-bold text-2xl md:text-3xl text-[#FA812F] mb-4">
                    1. Protect your account
                </h2>
                <ul class="custom-bullets space-y-2">
                    <li>
                        <strong>Strong Passwords:</strong> Use a unique combination of letters, numbers, and symbols. Never use the same password you use for other websites.
                    </li>
                    <li>
                        <strong>Keep it Private:</strong> Dukasaha support will never ask for your password or OTP (One-Time Password) via email, chat, or phone.
                    </li>
                    <li>
                        <strong>Log Out:</strong> Always log out of your account when using a shared or public computer.
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat font-bold text-2xl md:text-3xl text-[#FA812F] mb-4">
                    2. Beware of Phishing
                </h2>
                <ul class="custom-bullets space-y-2">
                    <li>
                        <strong>Check the URL:</strong> Ensure you are browsing on https://dukasaha.com. Be wary of look-alike links (e.g., dukasaha-support.com or duka-saha.net).
                    </li>
                    <li>
                        <strong>Suspicious Emails:</strong> Do not click on links in emails that claim your account is "locked" or "compromised" unless you requested a password reset.
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat font-bold text-2xl md:text-3xl text-[#FA812F] mb-4">
                    3. Report Suspicious Activity
                </h2>
                <p class="leading-relaxed">
                    If you see a suspicious profile, receive a strange message, or believe your account has 
                    been compromised, please contact us immediately at <a href="mailto:support@dukasaha.com" class="underline hover:text-[#FA812F]">support@dukasaha.com</a>.
                </p>
            </div>

        </div>

    </main>

    <footer class="relative w-full mt-auto">
        <div class="bg-[#FAB12F] h-24 w-full curve-footer flex items-center justify-center space-x-10 pt-6">
            
            <a href="{{route('terms')}}" class="relative text-white font-bold text-sm md:text-base group">
                Terms of Service
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

            <a href="{{route('privacy')}}" class="relative text-white font-bold text-sm md:text-base group">
                Privacy Policy
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

        </div>
    </footer>

</body>
</html>