@extends('layouts.app')

@section('title', 'Login')

@section('content')
<main class="px-4 sm:px-6 md:px-10 py-10">
    <div class="max-w-md mx-auto utyoube-card border border-[#2a2a2a] p-6 sm:p-8">
        <h1 class="text-2xl font-bold text-center mb-2">Login</h1>
        <p class="text-center text-sm text-gray-400 mb-8">Access your uTyoube account</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold mb-2 text-gray-300">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                             class="w-full bg-[#202020] border border-gray-700 rounded-lg p-3 focus:ring-2 focus:ring-red-600 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-2 text-gray-300">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                             class="w-full bg-[#202020] border border-gray-700 rounded-lg p-3 focus:ring-2 focus:ring-red-600 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-300">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="accent-red-600">
                Remember Me
            </label>

            <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                Login
            </button>

            <div class="flex items-center justify-between text-sm">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-green-500 hover:text-red-500 transition">Forgot Password?</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition">Create account</a>
                @endif
            </div>
        </form>
    </div>
</main>
@endsection
