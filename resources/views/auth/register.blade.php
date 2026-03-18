@extends('layouts.app')

@section('title', 'Register')

@section('content')
<main class="px-4 sm:px-6 md:px-10 py-10">
    <div class="max-w-lg mx-auto utyoube-card border border-[#2a2a2a] p-6 sm:p-8">
        <h1 class="text-2xl font-bold text-center mb-2">Create Account</h1>
        <p class="text-center text-sm text-gray-400 mb-8">Join and submit your YouTube links daily</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold mb-2 text-gray-300">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                             class="w-full bg-[#202020] border border-gray-700 rounded-lg p-3 focus:ring-2 focus:ring-red-600 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold mb-2 text-gray-300">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                             class="w-full bg-[#202020] border border-gray-700 rounded-lg p-3 focus:ring-2 focus:ring-red-600 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-2 text-gray-300">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                             class="w-full bg-[#202020] border border-gray-700 rounded-lg p-3 focus:ring-2 focus:ring-red-600 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password-confirm" class="block text-sm font-semibold mb-2 text-gray-300">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                             class="w-full bg-[#202020] border border-gray-700 rounded-lg p-3 focus:ring-2 focus:ring-red-600">
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                Register
            </button>

            <p class="text-sm text-center text-gray-300">
                Already have an account?
                <a href="{{ route('login') }}" class="text-green-500 hover:text-red-500 transition">Login</a>
            </p>
        </form>
    </div>
</main>
@endsection
