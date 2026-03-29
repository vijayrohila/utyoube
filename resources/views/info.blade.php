@extends('layouts.app')

@section('title', 'Information')

@section('content')

<!-- PROMOTION -->
<section class="max-w-4xl mx-auto px-4 py-12 text-center">
  <h2 class="text-2xl font-semibold mb-4 text-white">
    Promote 20+ Social Network Accounts for <span class="text-green-500">FREE</span> by Luck!
    <br>
    <span class="text-gray-400 text-sm font-normal">(Terms and Conditions Apply)</span>
  </h2>
  <p class="text-orange-500 text-xl mb-3 font-semibold">Visit :-</p>
  <a href="https://www.secminhr.com" target="_blank"
    class="text-green-500 text-2xl sm:text-6xl font-bold hover:underline break-words tracking-tight">
    www.secminhr.com
  </a>
  <br>
  <a href="https://www.secminhr.com" target="_blank">
    <div class="mx-auto max-w-2xl mt-8">
      <img src="{{ asset('images/secminhr.webp') }}" alt="SecMinHR" class="w-full">
    </div>
  </a>
</section>

<div class="max-w-4xl mx-auto px-4">
  <hr class="border-gray-700 opacity-50">
</div>

<!-- INTRO -->
<section class="max-w-4xl mx-auto px-4 py-14 text-center">
  <h1 class="text-4xl font-bold mb-6">Information &amp; Policies</h1>
  <p class="text-gray-300 leading-relaxed max-w-3xl mx-auto">
    Welcome to <span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span>! Here you will find all the information about our platform, services, policies, and how
    to get in touch with us. We value transparency, privacy, and user satisfaction.
  </p>
</section>

<!-- CONTENT SECTIONS -->
<main class="space-y-2">

  <!-- ABOUT -->
  <section class="max-w-4xl mx-auto px-4 py-10 border-t border-gray-700">
    <h2 class="text-2xl font-semibold mb-4">About Us</h2>
    <p class="text-gray-300 leading-relaxed">
      <span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span> is a platform designed to reward users for their participation and engagement with video content.
      We aim to create an inclusive environment where users feel valued for their contributions. Our mission is to
      provide transparent processes and fair opportunities for all participants worldwide.
    </p>
  </section>

  <!-- SERVICES -->
  <section class="max-w-4xl mx-auto px-4 py-10 border-t border-gray-700">
    <h2 class="text-2xl font-semibold mb-4">Our Services</h2>
    <ul class="list-disc list-inside text-gray-300 space-y-2">
      <li>Daily YouTube link submissions</li>
      <li>Winner selection based on user engagement</li>
      <li>Live visitor tracking and analytics</li>
      <li>Internationally accessible platform</li>
      <li>User support via email, WhatsApp, and phone</li>
    </ul>
  </section>

  <!-- TERMS -->
  <section class="max-w-4xl mx-auto px-4 py-10 border-t border-gray-700">
    <h2 class="text-2xl font-semibold mb-4">Terms and Conditions</h2>
    <p class="text-gray-300 leading-relaxed">
      By using our platform, you agree to comply with all rules and policies outlined on this page. Participation is
      completely voluntary and requires adherence to local and international laws. Users are expected to maintain
      honesty, fairness, and respect for the platform's guidelines. Misuse, fraud, or attempts to manipulate results
      may result in disqualification, account suspension, or permanent restriction.
    </p>
  </section>

  <!-- PRIVACY -->
  <section class="max-w-4xl mx-auto px-4 py-10 border-t border-gray-700">
    <h2 class="text-2xl font-semibold mb-4">Privacy Policy</h2>
    <p class="text-gray-300 leading-relaxed">
      We value your privacy and prioritize the protection of your personal data. Any information submitted to our
      platform is collected solely to provide accurate rewards and a better user experience. Your data will never be
      shared without consent. We use modern security measures and comply with privacy standards to ensure
      confidentiality and trust.
    </p>
  </section>

  <!-- INTERNATIONAL -->
  <section class="max-w-4xl mx-auto px-4 py-10 border-t border-gray-700">
    <h2 class="text-2xl font-semibold mb-4">International Policy</h2>
    <p class="text-gray-300 leading-relaxed">
      <span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span> is accessible globally, subject to local laws. We ensure fairness and equal opportunity for
      international users while maintaining compliance with cross-border regulations and security standards.
    </p>
  </section>

  <!-- LEGAL -->
  <section class="max-w-4xl mx-auto px-4 py-10 border-t border-gray-700">
    <h2 class="text-2xl font-semibold mb-4">Legal</h2>
    <p class="text-gray-300 leading-relaxed">
      <span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span> operates under applicable laws and regulations. Any disputes or claims are governed accordingly.
      Users are responsible for complying with legal requirements while using the platform.
    </p>
  </section>

  <!-- CONTACT -->
  <section class="max-w-4xl mx-auto px-4 py-10 border-t border-gray-700">
    <h2 class="text-2xl font-semibold mb-6">Contact Us</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 text-gray-300">
      <div>
        <h3 class="font-semibold mb-2">Headquarters</h3>
        <p>Gudivada, Krishna (District),<br>Andhra Pradesh, India – 521301</p>
      </div>
      <div>
        <h3 class="font-semibold mb-2">Email</h3>
        <a href="mailto:info@utyoube.com" class="text-red-500 hover:underline">
          info@utyoube.com
        </a>
      </div>
      <div>
        <h3 class="font-semibold mb-2">WhatsApp</h3>
        <a href="https://wa.me/919160268055" target="_blank" class="text-red-500 hover:underline">
          +91 9160268055
        </a>
      </div>
      <div>
        <h3 class="font-semibold mb-2">Mobile</h3>
        <a href="tel:+919160268055" class="text-red-500 hover:underline">
          +91 9160268055
        </a>
      </div>
    </div>
  </section>

</main>

@endsection
