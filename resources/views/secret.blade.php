@extends('layouts.app')

@section('title', 'Secret World')

@section('content')

<main class="px-4 sm:px-6 md:px-10">

  <section class="max-w-4xl mx-auto">
    <h3 class="text-xl sm:text-2xl font-bold text-center text-gray-200 mb-6">
      <span>
        <span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span> :
      </span> Your Professional Opportunity Hub
    </h3>

    <div class="p-4 sm:p-6 rounded-[14px] bg-gradient-to-br from-[#181818] to-[#202020] border border-[#2f2f2f] text-gray-300 space-y-4">
      <p>
        <span><span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span> :</span>
        is more than a platform—it's your Opportunity Hub, uniting an ecosystem of diamond-selected services to empower, educate, and deliver tangible gains today and tomorrow.
      </p>
      <p>
        Services are categorized into: <strong>Worldwide Services</strong> for global reach; <strong>Services Only in India</strong> for local needs/compliance; and <strong>Future Projects &amp; Investments</strong> for long-term growth.
      </p>
      <p>
        Many are earning opportunities: gain shares, skills, future benefits, insights, tools, and platforms for accelerated growth—with immediate and lasting value as stepping stones to success.
      </p>
      <p>
        Explore each carefully: read descriptions, note benefits/returns. Every diamond is a unique chance for knowledge, networks, and financial advantages—never underestimate even the smallest, as it could unlock big gains.
      </p>
      <p>
        Navigate the sectors below, immerse yourself—your growth, earnings, and learning start here. Secure every advantage; don't miss one!
      </p>
    </div>
  </section>

  <!-- Advertisement 1 -->
  <section>
    <div class="utyoube-ad">
      <p class="utyoube-ad-title mb-8">Advertisement</p>
      <p class="utyoube-ad-text mb-4">
        Promote Your <span class="text-[#FF0000]">YouTube</span> Video Links for Free by Luck – VlogUp.com
      </p>
      <a href="https://vlogup.com" target="_blank" class="utyoube-btn">Click to Visit</a>
    </div>
  </section>

  @php
  $projectCard = function(string $q, string $a, string $desc, string $url) {
      return compact('q','a','desc','url');
  };

  $worldWideLive = [
      ['q'=>'Want to see the strength of 2 Big Countries?','a'=>'Have A Share','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://haveashare.com'],
      ['q'=>'Want to promote your Social Account Links World Wide by Luck?','a'=>'SECMINHR','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://secminhr.com/home'],
      ['q'=>'Want to promote your YouTube Channel Video Links World Wide by Luck?','a'=>'Vlog Up','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://vlogup.com'],
  ];

  $worldWideFuture = [
      ['q'=>'Want to know Platform made for European Elites with Pride?','a'=>'7 E 5 U 5','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://7e5u5.com'],
      ['q'=>'Want to buy or register your bot for future?','a'=>'8 Billion Bots','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://8billionbots.com'],
      ['q'=>'Want to Build Business Network?','a'=>'Any X Any','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://anyxany.com'],
      ['q'=>'Want to get Crypto investing tips on live?','a'=>'Game of Tokens','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://gameoftokens.com'],
      ['q'=>'Want to Learn AI Upgrades, Designs and Functionalities?','a'=>'HI vs AI','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://hivsai.com'],
      ['q'=>'Want to Earn 100 Euros by Luck for Free?','a'=>'SayWings','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://saywings.eu'],
      ['q'=>'Want to Explore and Enjoy Europe in Budget?','a'=>'Viewrope','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://viewrope.com'],
  ];

  $indiaWideLive = [
      ['q'=>'Want to know the Game Changers in India?','a'=>'100K','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://100k.in'],
      ['q'=>'Want to win a product? Submit your Indian WhatsApp number and try your luck!','a'=>'0y0 - zero y zero','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://0y0.in'],
      ['q'=>'Want to win a silver coin? Submit your Indian WhatsApp number and try your luck!','a'=>'7 2 3 3','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://7233.in'],
      ['q'=>'Want to buy natural and pure honey?','a'=>'h1y - hONEy','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://h1y.in'],
      ['q'=>'Want to know the platform that helps random jobless people?','a'=>'Jobless Group','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://joblessgroup.com'],
      ['q'=>'Want to win money? Submit your Indian WhatsApp number and try your luck!','a'=>'m1y - mONEy','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://m1y.in'],
      ['q'=>'Want to hire telugu influencers and promote your brand?','a'=>'togethe R R R','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://togetherrr.org'],
      ['q'=>'Want to Find Politics, Politics, Politics, Indian Political Promoters?','a'=>'Vanara Group','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://vanaragroup.in'],
      ['q'=>'Want to know the platform where indians can buy products by paying zero gst?','a'=>'ZeroSGT','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://zerogst.in'],
  ];

  $indiaWideFuture = [
      ['q'=>'Want to buy automatic, innovative and future products?','a'=>'1 2 4 8','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://1248.in'],
      ['q'=>'Want to buy fitness equipment and travel packages in budget?','a'=>'Fitravel','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://fitravel.in'],
      ['q'=>'Want to know the information of gudivada?','a'=>'Gudivada','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://gudivada.net'],
      ['q'=>'Want to win an iphone? Submit your Indian WhatsApp number and try your luck!','a'=>'iph1','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://iph1.in'],
      ['q'=>'Want to fly airlines by paying time?','a'=>'Lavish Pegasus','desc'=>'A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.','url'=>'https://lavishpegasus.com'],
  ];
  @endphp

  @php
    function secretCard(array $project): string {
        return '<div class="border border-[#2f2f2f] p-4 mb-8 rounded-md relative bg-[#1a1a1a]">
          <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-shrink-0 flex justify-center sm:justify-start">
              <img src="https://placehold.co/128x80" alt="Project Logo" class="w-32 h-28 object-cover border border-[#333] rounded shadow-inner">
            </div>
            <div class="flex-grow mb-3">
              <div class="flex items-end mb-2 gap-2">
                <span class="font-bold text-gray-300">Q: ' . e($project['q']) . '</span>
              </div>
              <div class="flex items-end mb-2 gap-2">
                <span class="font-bold text-red-500">A: ' . e($project['a']) . '</span>
              </div>
              <div class="flex items-end mb-4 gap-2">
                <span class="text-gray-400">' . e($project['desc']) . '</span>
              </div>
              <ul class="mb-4 space-y-1 text-sm sm:text-base">
                <li class="text-[#22c55e] font-semibold">✔ Global accessibility</li>
                <li class="text-[#22c55e] font-semibold">✔ Secure &amp; scalable</li>
                <li class="text-[#22c55e] font-semibold">✔ User-focused design</li>
              </ul>
              <p class="text-xs sm:text-sm text-gray-500">* Terms &amp; Conditions apply</p>
            </div>
          </div>
          <div class="flex justify-center my-3">
            <a href="' . e($project['url']) . '" target="_blank" class="utyoube-btn">Visit Website</a>
          </div>
        </div>';
    }
  @endphp

  <!-- World Wide Live -->
  <section class="max-w-4xl mx-auto">
    <div class="p-4 sm:p-6 rounded-[14px] bg-gradient-to-br from-[#181818] to-[#202020] border border-[#2f2f2f] text-[#e5e5e5]">
      <h3 class="text-xl sm:text-2xl font-bold text-center text-[#22c55e] mb-6">World Wide Live</h3>
      @foreach($worldWideLive as $project)
        {!! secretCard($project) !!}
      @endforeach
    </div>
  </section>

  <!-- World Wide Future projects -->
  <section class="max-w-4xl mx-auto">
    <div class="p-4 sm:p-6 rounded-[14px] bg-gradient-to-br from-[#181818] to-[#202020] border border-[#2f2f2f] text-[#e5e5e5]">
      <h3 class="text-xl sm:text-2xl font-bold text-center text-[#22c55e] mb-6">World Wide Future projects</h3>
      @foreach($worldWideFuture as $project)
        {!! secretCard($project) !!}
      @endforeach
    </div>
  </section>

  <!-- Advertisement 2 -->
  <section>
    <div class="utyoube-ad">
      <p class="utyoube-ad-title mb-8">Advertisement</p>
      <p class="utyoube-ad-text mb-4">
        Promote 20+ Social Network Accounts Worldwide for Free by Luck – secminhr.com
      </p>
      <a href="https://secminhr.com" target="_blank" class="utyoube-btn">Click to Visit</a>
    </div>
  </section>

  <!-- India Wide Live -->
  <section class="max-w-4xl mx-auto">
    <div class="p-4 sm:p-6 rounded-[14px] bg-gradient-to-br from-[#181818] to-[#202020] border border-[#2f2f2f] text-[#e5e5e5]">
      <h3 class="text-xl sm:text-2xl font-bold text-center text-[#22c55e] mb-6">India Wide Live</h3>
      @foreach($indiaWideLive as $project)
        {!! secretCard($project) !!}
      @endforeach
    </div>
  </section>

  <!-- India Wide Future projects -->
  <section class="max-w-4xl mx-auto">
    <div class="p-4 sm:p-6 rounded-[14px] bg-gradient-to-br from-[#181818] to-[#202020] border border-[#2f2f2f] text-[#e5e5e5]">
      <h3 class="text-xl sm:text-2xl font-bold text-center text-[#22c55e] mb-6">India Wide Future projects</h3>
      @foreach($indiaWideFuture as $project)
        {!! secretCard($project) !!}
      @endforeach
    </div>
  </section>

  <!-- Advertisement 3 -->
  <section>
    <div class="utyoube-ad">
      <p class="utyoube-ad-title mb-8">Advertisement</p>
      <p class="utyoube-ad-text mb-4">
        For 2 Big Asian Markets : Win a "SHARE" of Daimond #Ad Earnings - HaveAShare.com
      </p>
      <a href="https://haveashare.com" target="_blank" class="utyoube-btn">Click to Visit</a>
    </div>
  </section>

  <!-- Elite Box -->
  <section class="max-w-4xl mx-auto">
    <div class="p-4 sm:p-6 rounded-[14px] bg-gradient-to-br from-[#181818] to-[#202020] border border-[#2f2f2f] text-[#e5e5e5]">
      <h3 class="text-xl sm:text-2xl font-bold text-center text-[#22c55e] mb-6">Elite Box</h3>
      <div class="border border-[#2f2f2f] p-4 mb-8 rounded-md relative bg-[#1a1a1a]">
        <div class="flex flex-col sm:flex-row gap-4">
          <div class="flex-shrink-0 flex justify-center sm:justify-start">
            <img src="https://placehold.co/128x80" alt="Project Logo" class="w-32 h-28 object-cover border border-[#333] rounded shadow-inner">
          </div>
          <div class="flex-grow mb-3">
            <div class="flex items-end mb-2 gap-2">
              <span class="font-bold text-gray-300">Q: Want to know.. What is hidden in the Elite Box?</span>
            </div>
            <div class="flex items-end mb-2 gap-2">
              <span class="font-bold text-red-500">A: 1000 Years Old Company</span>
            </div>
            <div class="flex items-end mb-4 gap-2">
              <span class="text-gray-400">A worldwide digital platform designed to support users with advanced tools, global accessibility, and high-performance infrastructure across all regions.</span>
            </div>
          </div>
        </div>
        <div class="flex justify-center my-3">
          <a href="https://1000yearsoldcompany.com" target="_blank" class="utyoube-btn">Visit Website</a>
        </div>
      </div>
    </div>
  </section>

</main>

@endsection
