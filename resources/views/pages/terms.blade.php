<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="view-transition" content="same-origin">
    <title>Terms of Service - Dukasaha</title>
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
                Terms of Service dukasaha
            </h1>
            <p class="text-[#F9A66C] text-sm md:text-base font-medium">
                Last updated : 16 December 2025
            </p>
        </div>

        <div class="text-[#F9A66C] font-medium text-base md:text-lg leading-relaxed mb-8">
            <p>
                Welcome to dukasaha.com. By accessing or using our website, you agree to be bound by 
                these Terms of Service. If you do not agree, please do not use our services.
            </p>
        </div>

        <div class="space-y-8 text-[#F9A66C] font-medium text-base md:text-lg">
            
            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    1. User Responsibility
                </h2>
                <ul class="custom-bullets">
                    <li>You must be at least 13 years old (or the minimum age in your country) to use this service.</li>
                    <li>You are responsible for any content you send through our platform.</li>
                    <li>Anonymity is not a license to harass. We do not tolerate bullying, hate speech, or threats.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    2. Prohibited Conduct
                </h2>
                <p class="mb-2">You agree not to use dukasaha.com to:</p>
                <ul class="custom-bullets">
                    <li>Harass, abuse, or stalk other users.</li>
                    <li>Send sexually explicit or pornographic content.</li>
                    <li>Spread spam, viruses, or malicious links.</li>
                    <li>Impersonate others for deceptive purposes.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    3. Data & Privacy
                </h2>
                <ul class="custom-bullets">
                    <li>While we facilitate anonymous messaging, we may collect certain technical data as outlined in our Privacy Policy.</li>
                    <li>We reserve the right to disclose user information if required by law or a valid legal process.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    4. Limitation of Liability
                </h2>
                <ul class="custom-bullets">
                    <li>dukasaha.com is provided "as is." We are not responsible for any emotional distress, harm, or damages resulting from the messages you receive or the interactions you have on this platform.</li>
                    <li>You use this service at your own risk.</li>
                </ul>
            </div>

            <div>
                <h2 class="font-montserrat text-xl md:text-2xl text-[#F9A66C] mb-2">
                    5. Termination
                </h2>
                <ul class="custom-bullets">
                    <li>We reserve the right to ban users or IP addresses that violate these terms without prior notice.</li>
                </ul>
            </div>

        </div>

    </main>

    <footer class="relative w-full mt-auto">
        <div class="bg-[#FAB12F] h-24 w-full curve-footer flex items-center justify-center space-x-10 pt-6">
            
            <a href="{{ route('terms') }}" class="relative text-white font-bold text-sm md:text-base group">
                Terms of Service
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-100"></span>
            </a>

            <a href="{{ route('privacy') }}" class="relative text-white font-bold text-sm md:text-base group">
                Privacy Policy
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 w-1.5 h-1.5 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
            </a>

        </div>
    </footer>

</body>
</html>