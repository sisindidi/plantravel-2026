<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Travel Planner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FD;
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen bg-[#F8F9FD]">

    <div class="w-full max-w-md bg-white rounded-[32px] p-10 shadow-sm border border-gray-100 mx-4">
        <div class="flex justify-center mb-6">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                <svg class="w-8 h-8 transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </div>
        </div>
        
        <h2 class="text-2xl font-extrabold text-center text-gray-900 mb-2">Selamat Datang!</h2>
        <p class="text-sm text-center text-gray-500 mb-8">Silakan masuk ke akun Travel Planner Anda.</p>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors"
                    placeholder="nama@email.com">
                @error('email')
                    <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lupa Password?</a>
                </div>
                <input type="password" name="password" id="password" required
                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-colors"
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-2xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all mt-4">
                Masuk ke Dashboard
            </button>
        </form>
    </div>

</body>
</html>
