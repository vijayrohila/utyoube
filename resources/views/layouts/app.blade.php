<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Promote Your YouTube Video Links for Free by Luck - Never Give Up!') - uTyoube.com</title>

  <meta name="description" content="Submit your YouTube video links and get featured on uTyoube.com Let's grow together through hard work and luck!">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('site.webmanifest') }}">

  <script src="https://cdn.tailwindcss.com"></script>

  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  @yield('head')
</head>

<body>
  <header class="sticky top-0 z-50 py-6 px-4 flex justify-center">
    <a href="{{ url('/') }}" class="flex items-center justify-center">
      <img src="{{ asset('images/arrow.svg') }}" alt="Logo" class="w-12 h-12 mr-2">
      <div class="flex items-center text-3xl sm:text-4xl font-bold flex-col">
        <div>
          <span class="text-green-500">u</span>
          <span class="text-red-500">T</span>
          <span class="text-green-500">you</span>
          <span class="text-red-500">be</span>
        </div>
      </div>
    </a>
  </header>

  @yield('content')

  <!-- FOOTER -->
  <footer class="text-center text-sm py-4 border-t border-gray-800">
    <p class="leading-8">
      Since 2024 – <span id="footeryear"></span><br>
      &copy; &amp; Concept by -
      <a href="{{ url('/') }}" class="font-semibold">
        <span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span>
      </a>
    </p>
  </footer>

  <script>document.getElementById("footeryear").textContent = new Date().getFullYear();</script>

  @yield('scripts')
</body>
</html>
