@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')

<main class="flex flex-col items-center justify-center min-h-[70vh] px-4 text-center space-y-6">
  <div class="relative">
    <h1 class="text-9xl font-extrabold text-[#202020] select-none">404</h1>
  </div>

  <div class="space-y-2">
    <h2 class="text-3xl md:text-4xl font-bold text-white">Error 404: Page Not Found</h2>
    <p class="text-gray-400 max-w-md mx-auto">
      The link you followed may be broken, or the page may have been removed.
    </p>
  </div>

  <div class="flex flex-col sm:flex-row gap-4 mt-4">
    <a href="{{ url('/') }}" class="utyoube-btn px-8 py-3 rounded-full font-bold transition-all transform hover:scale-105 shadow-lg shadow-red-900/20">
      Go to Home
    </a>
  </div>
</main>

@endsection
