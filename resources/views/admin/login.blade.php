<!DOCTYPE html>
<html lang="en" class="h-full bg-[#0f0f0f]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Login | uTyoube.com</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .glass {
      background: rgba(24, 24, 24, 0.8);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.05);
    }
  </style>
</head>

<body class="h-full flex items-center justify-center p-6 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-red-900/20 via-[#0f0f0f] to-[#0f0f0f]">

  <div class="max-w-md w-full space-y-8">
    <div class="text-center">
      <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-red-600 mb-6 shadow-2xl shadow-red-900/40 rotate-3 hover:rotate-0 transition-transform duration-300">
        <img src="{{ asset('images/arrow-w.svg') }}" alt="Logo" class="w-12 h-12">
      </div>
      <p class="mt-2 text-4xl font-black tracking-widest">
        <span style="color: green;">u</span>
        <span style="color: red;">T</span>
        <span style="color: green;">you</span>
        <span style="color: red;">be.com</span>
      </p>
      <h2 class="mt-3 text-2xl font-black text-white tracking-tighter">Admin Panel</h2>
    </div>

    <div class="mt-8 glass rounded-3xl shadow-2xl p-10 border border-white/5">

      @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 text-sm rounded-xl flex items-center">
          <i class="fa-solid fa-circle-check mr-3 text-lg"></i>
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-500 text-sm rounded-xl flex items-center">
          <i class="fa-solid fa-circle-exclamation mr-3 text-lg"></i>
          {{ session('error') }}
        </div>
      @endif

      @if($errors->has('email') || $errors->has('password'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-500 text-sm rounded-xl flex items-center">
          <i class="fa-solid fa-circle-exclamation mr-3 text-lg"></i>
          {{ $errors->first('email') ?: $errors->first('password') }}
        </div>
      @endif

      <form class="space-y-6" action="{{ route('admin.login.post') }}" method="POST">
        @csrf
        <div>
          <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Email</label>
          <input id="email" name="email" type="email" required value="{{ old('email') }}"
            class="appearance-none block w-full px-5 py-4 bg-[#0a0a0a] border border-[#2a2a2a] rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition duration-200 sm:text-sm font-medium"
            placeholder="Enter email">
        </div>

        <div>
          <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Password</label>
          <input id="password" name="password" type="password" required
            class="appearance-none block w-full px-5 py-4 bg-[#0a0a0a] border border-[#2a2a2a] rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition duration-200 sm:text-sm font-medium"
            placeholder="Enter password">
        </div>

        <div>
          <button type="submit"
            class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none transition duration-200 shadow-xl shadow-red-900/20 active:scale-95 uppercase tracking-widest">
            LogIn
          </button>
        </div>
      </form>
    </div>

    <p class="text-center text-[12px] text-gray-600 tracking-[0.3em] font-bold">
      &copy; {{ date('Y') }} <span class="text-gray-500"> - uTyoube.com</span>
    </p>
  </div>

</body>
</html>
