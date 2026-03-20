@extends('admin.layouts.app')

@section('title', 'Change Password')

@section('content')
<main class="py-10 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto">

  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-white tracking-tight">Change Password</h1>
    <p class="mt-1 text-gray-400">Update your admin account password.</p>
  </div>

  <!-- Flash Messages -->
  @if(session('success'))
    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl border border-green-500/30 bg-green-500/10 text-green-400">
      <i class="fa-solid fa-circle-check flex-shrink-0"></i>
      <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-400">
      <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
      <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="mb-6 p-4 rounded-xl border border-red-500/30 bg-red-500/10">
      <ul class="space-y-1">
        @foreach($errors->all() as $error)
          <li class="flex items-center gap-2 text-sm text-red-400">
            <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
            {{ $error }}
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Change Password Card -->
  <div class="bg-[#181818] rounded-2xl border border-[#2a2a2a] shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-[#2a2a2a] bg-[#212121]/50">
      <h2 class="text-lg font-semibold text-white flex items-center gap-2">
        <i class="fa-solid fa-lock text-red-500 text-base"></i>
        Update Password
      </h2>
    </div>

    <form id="change-password-form" method="POST" action="{{ route('admin.change-password.post') }}" class="p-6 space-y-5" novalidate>
      @csrf

      <!-- Current Password -->
      <div>
        <label for="current_password" class="block text-sm font-semibold text-gray-300 mb-2">
          Current Password <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input
            type="password"
            name="current_password"
            id="current_password"
            autocomplete="current-password"
            required
            placeholder="Enter your current password"
            class="block w-full bg-[#0f0f0f] border border-[#2a2a2a] rounded-xl text-white placeholder-gray-600 focus:ring-1 focus:ring-red-500 focus:border-red-500 text-sm h-12 px-4 pr-12 transition-colors"
          >
          <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors p-1">
            <i class="fa-solid fa-eye text-sm"></i>
          </button>
        </div>
      </div>

      <!-- New Password -->
      <div>
        <label for="new_password" class="block text-sm font-semibold text-gray-300 mb-2">
          New Password <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input
            type="password"
            name="new_password"
            id="new_password"
            autocomplete="new-password"
            required
            placeholder="Enter a strong new password"
            class="block w-full bg-[#0f0f0f] border border-[#2a2a2a] rounded-xl text-white placeholder-gray-600 focus:ring-1 focus:ring-red-500 focus:border-red-500 text-sm h-12 px-4 pr-12 transition-colors"
          >
          <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors p-1">
            <i class="fa-solid fa-eye text-sm"></i>
          </button>
        </div>
        <p class="mt-1.5 text-xs text-gray-500">Minimum 8 characters, must include uppercase, lowercase and a number.</p>
      </div>

      <!-- Confirm Password -->
      <div>
        <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-300 mb-2">
          Confirm New Password <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input
            type="password"
            name="new_password_confirmation"
            id="new_password_confirmation"
            autocomplete="new-password"
            required
            placeholder="Re-enter your new password"
            class="block w-full bg-[#0f0f0f] border border-[#2a2a2a] rounded-xl text-white placeholder-gray-600 focus:ring-1 focus:ring-red-500 focus:border-red-500 text-sm h-12 px-4 pr-12 transition-colors"
          >
          <button type="button" onclick="togglePassword('new_password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors p-1">
            <i class="fa-solid fa-eye text-sm"></i>
          </button>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="pt-2">
        <button
          type="submit"
          class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 focus:ring-offset-[#181818] transition-all duration-200 active:scale-[0.98] shadow-lg shadow-red-900/20"
        >
          <i class="fa-solid fa-shield-halved mr-2"></i>
          Update Password
        </button>
      </div>
    </form>
  </div>

</main>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.21.0/dist/jquery.validate.min.js"></script>
<script>
  // Custom validator: password strength (uppercase + lowercase + number)
  $.validator.addMethod('strongPassword', function (value) {
    return /[A-Z]/.test(value) && /[a-z]/.test(value) && /[0-9]/.test(value);
  }, 'Password must contain at least one uppercase letter, one lowercase letter, and one number.');

  $('#change-password-form').validate({
    rules: {
      current_password: {
        required: true,
      },
      new_password: {
        required: true,
        minlength: 8,
        strongPassword: true,
      },
      new_password_confirmation: {
        required: true,
        equalTo: '#new_password',
      },
    },
    messages: {
      current_password: {
        required: 'Please enter your current password.',
      },
      new_password: {
        required: 'Please enter a new password.',
        minlength: 'Password must be at least 8 characters.',
      },
      new_password_confirmation: {
        required: 'Please confirm your new password.',
        equalTo: 'Passwords do not match.',
      },
    },
    errorPlacement: function (error, element) {
      error.addClass('text-red-400 text-xs mt-1.5 flex items-center gap-1');
      error.prepend('<i class="fa-solid fa-circle-exclamation flex-shrink-0"></i> ');
      element.closest('.relative').after(error);
    },
    highlight: function (element) {
      $(element).removeClass('border-[#2a2a2a]').addClass('border-red-500');
    },
    unhighlight: function (element) {
      $(element).removeClass('border-red-500').addClass('border-[#2a2a2a]');
    },
    submitHandler: function (form) {
      form.submit();
    },
  });

  function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }
</script>
@endsection
