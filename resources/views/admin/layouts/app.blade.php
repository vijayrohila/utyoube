<!DOCTYPE html>
<html lang="en" class="h-full bg-[#0f0f0f]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') | uTyoube Admin</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>body { font-family: 'Inter', sans-serif; background-color: #0f0f0f; color: #e5e5e5; }</style>
  @yield('head')
</head>
<body class="h-full">

  <nav class="bg-[#181818] border-b border-[#2a2a2a] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-20">
        <div class="flex">
          <div class="flex-shrink-0 flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-xl font-bold">
              <img src="{{ asset('images/arrow.svg') }}" alt="Logo" class="w-8 h-8">
              <span class="text-white"><span class="text-red-500">uTyoube</span> <span class="text-xs uppercase bg-red-600 text-white px-1.5 py-0.5 rounded ml-1">Admin</span></span>
            </a>
          </div>
          <div class="hidden sm:-my-px sm:ml-8 sm:flex sm:space-x-8">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'border-red-500 text-white' : 'border-transparent text-gray-400 hover:text-white hover:border-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150">
              Dashboard
            </a>
          </div>
        </div>

        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <div class="ml-3 relative flex items-center space-x-6">
            <span class="text-sm text-gray-400">
              <i class="fa-solid fa-user-circle mr-1 opacity-50"></i>
              {{ auth()->user()->name ?? 'Admin' }}
            </span>
            <a href="{{ route('admin.change-password') }}" class="text-gray-400 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
              <i class="fa-solid fa-key mr-1 opacity-50"></i> Change Password
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" class="inline">
              @csrf
              <button type="submit" class="bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-bold transition duration-150 ease-in-out shadow-lg shadow-red-900/20">
                <i class="fa-solid fa-sign-out-alt mr-1"></i> Logout
              </button>
            </form>
          </div>
        </div>

        <div class="flex items-center sm:hidden">
          <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-[#2a2a2a] focus:outline-none transition-colors">
            <i class="fa-solid fa-bars text-2xl" id="menu-icon"></i>
            <i class="fa-solid fa-xmark text-2xl hidden" id="close-icon"></i>
          </button>
        </div>
      </div>
    </div>

    <div id="mobile-menu" class="hidden sm:hidden border-t border-[#2a2a2a] bg-[#181818] shadow-2xl">
      <div class="pt-2 pb-3 space-y-1 px-4">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-red-500/10 text-red-500' : 'text-gray-400 hover:bg-[#2a2a2a] hover:text-white' }} block px-3 py-3 rounded-xl text-base font-bold transition-colors">
          <i class="fa-solid fa-chart-line mr-3 w-5"></i> Dashboard
        </a>
      </div>
      <div class="pt-4 pb-3 border-t border-[#2a2a2a] px-4">
        <div class="flex items-center px-3 mb-4">
          <div class="flex-shrink-0">
            <i class="fa-solid fa-user-circle text-gray-500 text-4xl"></i>
          </div>
          <div class="ml-3">
            <div class="text-base font-bold text-white">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="text-xs font-medium text-gray-500 uppercase tracking-widest">Administrator</div>
          </div>
        </div>
        <div class="space-y-1">
          <a href="{{ route('admin.change-password') }}" class="block px-3 py-3 rounded-xl text-base font-medium text-gray-400 hover:bg-[#2a2a2a] hover:text-white transition-colors">
            <i class="fa-solid fa-key mr-3 w-5"></i> Change Password
          </a>
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full text-left block px-3 py-3 rounded-xl text-base font-bold text-red-500 hover:bg-red-500/10 transition-colors">
              <i class="fa-solid fa-sign-out-alt mr-3 w-5"></i> Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      document.getElementById('mobile-menu').classList.toggle('hidden');
      document.getElementById('menu-icon').classList.toggle('hidden');
      document.getElementById('close-icon').classList.toggle('hidden');
    });
  </script>

  @yield('content')

  <footer class="mt-auto py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <p class="text-center text-[12px] text-gray-300 tracking-[0.3em] font-bold">
        &copy; {{ date('Y') }} <span class="text-white"> - uTyoube.com</span>
      </p>
    </div>
  </footer>

  @yield('scripts')
</body>
</html>
