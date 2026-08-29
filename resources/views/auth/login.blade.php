<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Loksewa LMS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-2xl shadow-gray-100 w-full max-w-md">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-gray-900 mb-2 tracking-tight">Welcome Back</h1>
            <p class="text-gray-400 text-sm font-medium">Continue your Loksewa preparation</p>
        </div>

        <form action="{{ url('/login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                <input type="email" name="email" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                @error('email') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-bold text-lg transition-all shadow-xl shadow-emerald-50">
                Sign In
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-gray-50 text-center">
            <p class="text-sm text-gray-400">Need an account? <span class="text-emerald-600 font-bold">Contact Admin</span></p>
        </div>
    </div>
</body>
</html>
