<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Planner Dashboard</title>
    <!-- Use Tailwind CDN to guarantee styling works immediately without npm run dev -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        indigo: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FD;
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="text-gray-800 antialiased h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-[280px] bg-white border-r border-gray-100 flex flex-col h-full hidden lg:flex shrink-0">
        <div class="p-8 pb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <svg class="w-6 h-6 transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 leading-none">Travel Planner</h1>
                    <p class="text-[11px] text-gray-500 font-medium mt-1">Plan your best trip</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto no-scrollbar">
            <a href="/" class="flex items-center space-x-4 {{ request()->is('/') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-500 hover:text-indigo-600 hover:bg-indigo-50/50' }} px-5 py-3.5 rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5 {{ request()->is('/') ? 'opacity-100' : 'opacity-90' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-sm">Dashboard</span>
            </a>
            <a href="{{ route('frontend.trips') }}" class="flex items-center space-x-4 {{ request()->routeIs('frontend.trips') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-500 hover:text-indigo-600 hover:bg-indigo-50/50' }} px-5 py-3.5 rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="text-sm">My Trips</span>
            </a>
            <a href="{{ route('frontend.itineraries') }}" class="flex items-center space-x-4 {{ request()->routeIs('frontend.itineraries') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-500 hover:text-indigo-600 hover:bg-indigo-50/50' }} px-5 py-3.5 rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-sm">Itinerary</span>
            </a>
            <a href="{{ route('frontend.expenses') }}" class="flex items-center space-x-4 {{ request()->routeIs('frontend.expenses') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-500 hover:text-indigo-600 hover:bg-indigo-50/50' }} px-5 py-3.5 rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm">Budget Planner</span>
            </a>
            <a href="{{ route('frontend.packinglists') }}" class="flex items-center space-x-4 {{ request()->routeIs('frontend.packinglists') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-500 hover:text-indigo-600 hover:bg-indigo-50/50' }} px-5 py-3.5 rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm">Checklist</span>
            </a>
            <a href="{{ route('frontend.destinations') }}" class="flex items-center space-x-4 {{ request()->routeIs('frontend.destinations') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-500 hover:text-indigo-600 hover:bg-indigo-50/50' }} px-5 py-3.5 rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <span class="text-sm">Wishlist Destinasi</span>
            </a>
        </nav>

        <div class="p-6">
            <div class="bg-indigo-50/50 rounded-3xl p-5 text-center border border-indigo-100 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <svg class="w-24 h-24 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2 relative z-10">Siap Berpetualang?</h4>
                <p class="text-xs text-gray-500 mb-5 relative z-10">Rencanakan perjalanan impianmu dengan mudah!</p>
                <button type="button" onclick="openTripModal()" class="block bg-indigo-600 text-white w-full py-3 rounded-2xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all relative z-10">Buat Trip Baru</button>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Header -->
        <header class="h-[90px] bg-transparent flex items-center justify-between px-10 shrink-0">
            <div>
                <h2 class="text-[28px] font-extrabold text-gray-900 tracking-tight">Halo, {{ explode(' ', auth()->user()->name ?? 'User')[0] }}! <span class="wave">👋</span></h2>
                <p class="text-[13px] text-gray-500 font-medium mt-1">Yuk rencanakan perjalanan berikutnya dan buat momen tak terlupakan!</p>
            </div>
            <div class="flex items-center space-x-6">
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-gray-500 hover:text-red-500 flex items-center space-x-1 transition-colors bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar</span>
                    </button>
                </form>

                <button class="w-11 h-11 bg-white rounded-full flex items-center justify-center shadow-sm relative text-gray-400 hover:text-indigo-600 border border-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-2 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center space-x-3 bg-white pr-5 pl-1.5 py-1.5 rounded-full shadow-sm cursor-pointer border border-gray-100 hover:shadow-md transition-shadow">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=e0e7ff&color=4f46e5&bold=true" alt="{{ auth()->user()->name ?? 'User' }}" class="w-9 h-9 rounded-full">
                    <span class="text-[13px] font-bold text-gray-700">{{ explode(' ', auth()->user()->name ?? 'User')[0] }}</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto px-10 pb-10 no-scrollbar">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
    
    <style>
        .wave {
            animation-name: wave-animation;
            animation-duration: 2.5s;
            animation-iteration-count: infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }
        @keyframes wave-animation {
            0% { transform: rotate( 0.0deg) }
            10% { transform: rotate(14.0deg) }
            20% { transform: rotate(-8.0deg) }
            30% { transform: rotate(14.0deg) }
            40% { transform: rotate(-4.0deg) }
            50% { transform: rotate(10.0deg) }
            60% { transform: rotate( 0.0deg) }
            100% { transform: rotate( 0.0deg) }
        }
    </style>
</body>
</html>
