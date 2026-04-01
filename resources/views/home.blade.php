@extends('layouts.app')

@section('title', 'Promote Your YouTube Video Links for Free by Luck - Never Give Up!')

@section('head')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')

<!-- ===============================
     MAIN CONTENT
     =============================== -->
<main class="px-4 sm:px-6 md:px-10">

  <section class="max-w-3xl mx-auto">
    <div class="p-4 sm:p-6 rounded-[14px] bg-gradient-to-br from-[#181818] to-[#202020] border border-[#2f2f2f] text-gray-300 space-y-4">
      <h3 class="text-xl sm:text-2xl font-bold text-center text-gray-200 mb-6 flex flex-col items-centers space-y-2">
        <span>Welcome</span>
        <span>to</span>
        <span class="tracking-widest"><span class="text-green-500">u</span><span class="text-red-500">T</span><span class="text-green-500">you</span><span class="text-red-500">be</span><span class="text-white">.com</span></span>
      </h3>
      <p class="text-center">
        A heartfelt <span class="text-green-500">Thanks</span> to <span class="text-[#FF0000]">YouTube</span> for making the world brighter, smarter, and more connected.
      </p>
      <p class="text-center">
        <span class="text-[#FF0000]">YouTube</span> services, analytics, and endless information have empowered millions.
      </p>
      <p class="text-center">
        We love <span class="text-[#FF0000]">YouTube</span> for life for the positive impact it has created globally.
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

  <!-- Visitors Statistics -->
  <section>
    <div class="utyoube-card max-w-xl mx-auto p-6 text-center space-y-3">
      <p class="font-semibold">Live Visitors: <span id="liveVisitors" class="text-red-500">{{ $stats['live'] ?? 0 }}</span></p>
      <p class="font-semibold">Today's Visitors: <span id="todaysVisitors" class="text-green-500">{{ $stats['today'] ?? 0 }}</span></p>
      <p class="font-semibold">Total Visitors: <span id="totalVisitors" class="text-blue-500">{{ $stats['total'] ?? 0 }}</span></p>
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

  <!-- YouTube Submission Box -->
  <section class="max-w-7xl mx-auto md:px-4">
    <h3 class="text-xl font-semibold text-center mb-5">
      Click on <span class="text-green-500">Past Day Winner</span> to Submit Your <span class="text-[#FF0000]">YouTube</span> Video Link
    </h3>

    <h4 class="text-center mb-10">
      Everyday you have 6 chances to submit your links. Use all of them. Each chance gives you a better opportunity to win a space tomorrow and grow your network by Luck.
    </h4>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 justify-center align-center">

      @php
        $chances = [1, 2, 3, 4, 5, 6];
        $winnersMap = $winners ?? [];
        $fallbackLinks = $fallbackWinnerLinks ?? [];
      @endphp

      @foreach($chances as $chance)
      @php
        $chanceWinner = $winnersMap[$chance] ?? null;
        $chanceLink = $chanceWinner
          ? $chanceWinner['youtube_link']
          : ($fallbackLinks[$chance] ?? 'https://www.youtube.com');
        $chanceClicks = $chanceWinner ? $chanceWinner['clicks'] : 0;
        $chanceWinnerId = $chanceWinner ? $chanceWinner['id'] : '';
      @endphp
      <div id="utyoubeBox{{ $chance }}" class="utyoube-card border border-red-600 p-6 w-full max-w-sm">
        <h4 class="text-center text-2xl font-semibold text-green-500 mb-4">
          CHANCE - {{ $chance }}
        </h4>

        <div class="flex gap-3 mb-4">
          <a id="utyoubeBtn{{ $chance }}" href="{{ $chanceLink }}" target="_blank"
            data-winner-id="{{ $chanceWinnerId }}"
            class="flex-1 bg-red-600 text-white py-2 rounded-lg text-center font-semibold hover:bg-red-700">
            Past Day Winner
          </a>

          <div class="w-24 bg-white text-red-500 py-1.5 text-sm rounded-lg border border-white flex items-center justify-center font-semibold">
            Clicks - <span id="winnerClicks{{ $chance }}">{{ $chanceClicks }}</span>
          </div>
        </div>

        <!-- Hidden until wait condition passes -->
        <div id="utyoubeFields{{ $chance }}" class="hidden-fields">
          <input id="utyoubeInput{{ $chance }}" type="text" placeholder="Paste your YouTube link here...."
            class="w-full bg-[#202020] border border-gray-700 rounded-md p-2 mb-4 focus:ring-2 focus:ring-red-600"
            disabled>

          <button id="utyoubeSubmit{{ $chance }}" class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 font-semibold"
            disabled>
            Submit
          </button>
        </div>
      </div>
      @endforeach

    </div>
  </section>

  <!-- Motivation -->
  <section class="text-center mt-0">
    <h3 class="text-xl font-semibold mb-8">Submit Consistently – Never Give Up!</h3>
    <a href="{{ url('/info') }}" class="inline-block bg-white px-4 py-2 rounded-lg hover:shadow-lg transition"
      style="color: var(--utyoube-red); font-weight: 600;">Information
    </a>
    <p class="text-xs mt-8 text-gray-400">(Terms and Conditions Apply)</p>
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

  <!-- Winners Table -->
  <section>
    <h3 class="text-4xl font-bold text-center mb-6">Winners</h3>

    <!-- Search + Page Size -->
    <div class="flex flex-col md:flex-row gap-3 max-w-4xl mx-auto mb-8">
      <input id="winnerSearch" type="text" placeholder="Search by date or link..."
        class="flex-1 bg-[#202020] border border-gray-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-gray-500">

      <select id="perPageSelect"
        class="bg-[#202020] border border-gray-500 rounded-md px-3 py-2 w-full md:w-[85px] select-custom-arrow">
        <option selected>10</option>
        <option>25</option>
        <option>50</option>
        <option>100</option>
      </select>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto max-w-6xl mx-auto utyoube-card">
      <table id="winnerTable" class="w-full text-center winners-table-vertical-lines">
        <thead class="bg-[#202020] border-b border-gray-700">
          <tr>
            <th class="px-3 py-3">Date</th>
            <th class="px-3 py-3">Total links</th>
            <th class="px-3 py-3">Winners</th>
            <th class="px-3 py-3">Winner Profit by Visits</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <div id="pagination" class="flex flex-wrap justify-center gap-2 overflow-x-auto px-2 mt-6 mb-6 sm:mb-8 sm:mt-8">
    </div>
  </section>

  <section>
    <div class="flex justify-center">
      <a href="{{ url('/secret') }}" class="inline-block bg-transparent px-10 py-4 rounded-lg hover:shadow-lg transition text-2xl"
        style="color: #22c55e; font-weight: 600; border: 1px solid #22c55e;">Secret World</a>
    </div>
  </section>

</main>

@endsection

@section('scripts')
<script>
  function utyoubeSwalBase() {
    return {
      background: '#181818',
      color: '#e5e7eb',
      confirmButtonColor: '#dc2626',
      confirmButtonText: 'OK',
      customClass: { popup: 'utyoube-swal-popup' },
    };
  }

  function utyoubeAlert(title, text, icon) {
    if (typeof Swal === 'undefined') {
      window.alert(text || title);
      return Promise.resolve();
    }
    return Swal.fire({
      ...utyoubeSwalBase(),
      icon: icon || 'info',
      title: title || '',
      text: text || '',
    });
  }

  function showEarlyReturnSwal(seconds) {
    const s = Math.max(1, parseInt(seconds, 10) || 5);
    if (typeof Swal === 'undefined') {
      window.alert('Please watch the video for at least ' + s + ' seconds, then try again.');
      return Promise.resolve();
    }
    return Swal.fire({
      ...utyoubeSwalBase(),
      icon: 'info',
      title: 'Almost there!',
      confirmButtonText: 'Got it',
      width: '32rem',
      html:
        '<p class="text-left mb-4 leading-relaxed" style="color:#e5e7eb">' +
        "Hey submitter, it's too fast. One day your link will win, and someone will have to watch your YouTube video for at least <strong>" +
        s +
        '</strong> seconds. Today is your turn to watch.</p>' +
        '<p class="text-left leading-relaxed" style="color:#e5e7eb">' +
        "Now click again, watch someone's video for at least <strong>" +
        s +
        '</strong> seconds, then come back to submit your YouTube video link — Thanks!</p>',
    });
  }

  let waitTimeMs = {{ ($minViewSeconds ?? 5) * 1000 }};
  const STORAGE_KEY = 'utyoubeChanceAccess';

  function requiredWaitMs(access) {
    const ms = access && access.waitMs != null ? Number(access.waitMs) : waitTimeMs;
    return Number.isFinite(ms) && ms > 0 ? ms : waitTimeMs;
  }

  function requiredWaitSeconds(access) {
    return Math.round(requiredWaitMs(access) / 1000);
  }

  function getChanceStore() {
    try {
      return JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '{}');
    } catch (error) {
      return {};
    }
  }

  function setChanceStore(store) {
    sessionStorage.setItem(STORAGE_KEY, JSON.stringify(store));
  }

  function setChanceAccess(chance, payload) {
    const store = getChanceStore();
    store[chance] = payload;
    setChanceStore(store);
  }

  function isMobileDevice() {
    return (
      /Android|iPhone|iPad|iPod|Mobile|Opera Mini/i.test(navigator.userAgent) ||
      (navigator.maxTouchPoints && navigator.maxTouchPoints > 2 && window.innerWidth < 1024)
    );
  }

  function clearChanceAccess(chance) {
    const store = getChanceStore();
    delete store[chance];
    setChanceStore(store);
  }

  function getChanceAccess(chance) {
    const store = getChanceStore();
    return store[chance] || null;
  }

  function showFields(chance) {
    const fields = document.getElementById(`utyoubeFields${chance}`);
    if (!fields) return;
    fields.classList.remove('hidden-fields');
    fields.classList.add('visible-fields');
    document.getElementById(`utyoubeInput${chance}`).disabled = false;
    document.getElementById(`utyoubeSubmit${chance}`).disabled = false;
  }

  function hideFields(chance) {
    const fields = document.getElementById(`utyoubeFields${chance}`);
    if (!fields) return;
    fields.classList.remove('visible-fields');
    fields.classList.add('hidden-fields');
    document.getElementById(`utyoubeInput${chance}`).disabled = true;
    document.getElementById(`utyoubeSubmit${chance}`).disabled = true;
  }

  function isValidYoutubeUrl(url) {
    const pattern = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/;
    return pattern.test(url);
  }

  function setWinnerClicks(chance, clicks) {
    const el = document.getElementById(`winnerClicks${chance}`);
    if (el) {
      el.textContent = clicks;
    }
  }

  function canChanceSubmit(access) {
    if (!access || !access.token || !access.availableAt || !access.leftAtMs) return false;
    const nowSeconds = Math.floor(Date.now() / 1000);
    const awayTimeMs = Date.now() - Number(access.leftAtMs || 0);
    const waitedEnough = awayTimeMs >= requiredWaitMs(access);
    const serverWindowOpen = nowSeconds >= Number(access.availableAt || 0);
    return waitedEnough && serverWindowOpen;
  }

  function evaluateChanceOnReturn(chance) {
    if (!chance) return;
    const access = getChanceAccess(chance);
    if (!access) return;

    if (!access.token) {
      clearChanceAccess(chance);
      hideFields(chance);
      return;
    }

    if (canChanceSubmit(access)) {
      setChanceAccess(chance, { ...access, canSubmit: true });
      showFields(chance);
    } else {
      const secs = requiredWaitSeconds(access);
      clearChanceAccess(chance);
      hideFields(chance);
      showEarlyReturnSwal(secs);
      return;
    }
  }

  const CHANCES = [1, 2, 3, 4, 5, 6];

  async function updateClicks(chance) {
    const btn = document.getElementById(`utyoubeBtn${chance}`);
    const winnerId = btn ? (btn.dataset.winnerId || '') : '';
    const formData = new FormData();
    formData.append('button_id', `utyoube${chance}`);
    formData.append('chance', chance);
    formData.append('winner_id', winnerId);
    formData.append('_token', document.querySelector('meta[name=csrf-token]').content);
    const response = await fetch('{{ url("/api/click") }}', { method: 'POST', body: formData });
    const data = await response.json();
    if (typeof data.clicks !== 'undefined') {
      setWinnerClicks(chance, data.clicks);
    }
    return data;
  }

  @foreach([1,2,3,4,5,6] as $chance)
  (function() {
    const chance = {{ $chance }};
    const btn = document.getElementById('utyoubeBtn{{ $chance }}');
    const submitBtn = document.getElementById('utyoubeSubmit{{ $chance }}');
    const input = document.getElementById('utyoubeInput{{ $chance }}');

    const existingAccess = getChanceAccess(chance);
    if (existingAccess && canChanceSubmit(existingAccess)) {
      setChanceAccess(chance, { ...existingAccess, canSubmit: true });
      showFields(chance);
    } else {
      if (existingAccess) {
        if (!existingAccess.token) {
          clearChanceAccess(chance);
        } else {
          setChanceAccess(chance, { ...existingAccess, canSubmit: false });
        }
      }
      hideFields(chance);
    }

    if (btn) {
      btn.addEventListener('click', async e => {
        e.preventDefault();

        const clickedAtMs = Date.now();
        setChanceAccess(chance, {
          leftAtMs: clickedAtMs,
          token: null,
          availableAt: null,
          canSubmit: false,
        });
        hideFields(chance);

        try {
          const data = await updateClicks(chance);
          if (data.success && data.token && data.available_at) {
            if (typeof data.min_view_seconds === 'number' && data.min_view_seconds > 0) {
              waitTimeMs = data.min_view_seconds * 1000;
            }
            const current = getChanceAccess(chance) || {};
            setChanceAccess(chance, {
              ...current,
              token: data.token,
              availableAt: data.available_at,
              waitMs: waitTimeMs,
              canSubmit: false,
            });
          }      
        } catch (error) {
          console.error('Click tracking error:', error);
        }
        if (isMobileDevice()) {
            // Mobile → same tab (REQUIRED for timer)
            window.location.href = btn.href;
        } else {
            // Desktop → new tab (better UX)
            window.open(btn.href, '_blank', 'noopener,noreferrer');
        }        
      });
    }

    if (submitBtn) {
      submitBtn.addEventListener('click', async () => {
        const link = input.value.trim();
        const access = getChanceAccess(chance);

        if (!access || !access.token) {
          clearChanceAccess(chance);
          hideFields(chance);
          await utyoubeAlert('Unlock required', 'Click on Past Day Winner first to unlock this chance.', 'warning');
          return;
        }
        if (!canChanceSubmit(access) || !access.canSubmit) {
          await showEarlyReturnSwal(requiredWaitSeconds(access));
          return;
        }
        if (Math.floor(Date.now() / 1000) < access.availableAt) {
          await showEarlyReturnSwal(requiredWaitSeconds(access));
          return;
        }
        if (!link) {
          await utyoubeAlert('Link required', 'Paste your YouTube link before submitting.', 'warning');
          return;
        }
        if (!isValidYoutubeUrl(link)) {
          await utyoubeAlert('Invalid link', 'Please enter a valid YouTube link.', 'error');
          return;
        }

        const formData = new FormData();
        formData.append('link', link);
        formData.append('chance', chance);
        formData.append('access_token', access.token);
        formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

        try {
          const response = await fetch('{{ route("submit.link") }}', { method: 'POST', body: formData });
          const data = await response.json();
          if (data.success) {
            if (typeof Swal !== 'undefined') {
              await Swal.fire({
                ...utyoubeSwalBase(),
                icon: 'success',
                title: 'Submitted',
                text: data.message || 'Your link was submitted.',
              });
              clearChanceAccess(chance);
              input.value = '';
              location.reload();
            } else {
              window.alert(data.message);
              clearChanceAccess(chance);
              input.value = '';
              location.reload();
            }
          } else {
            clearChanceAccess(chance);
            hideFields(chance);
            await utyoubeAlert('Could not submit', data.error || 'Something went wrong.', 'error');
          }
        } catch (e) {
          await utyoubeAlert('Error', 'An error occurred. Please try again.', 'error');
        }
      });
    }
  })();
  @endforeach

  function handleReturnToPage() {
    CHANCES.forEach(chance => evaluateChanceOnReturn(chance));
  }

  window.addEventListener('focus', handleReturnToPage);
  window.addEventListener('pageshow', handleReturnToPage);
  document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
      handleReturnToPage();
    }
  });

  /* ===============================
     VISITOR COUNTER (Auto-Update)
     =============================== */
  async function refreshVisitorStats() {
    try {
      const response = await fetch('{{ route("api.stats") }}');
      if (!response.ok) return;
      const data = await response.json();
      if (data.live !== undefined) document.getElementById('liveVisitors').textContent = data.live;
      if (data.today !== undefined) document.getElementById('todaysVisitors').textContent = data.today;
      if (data.total !== undefined) document.getElementById('totalVisitors').textContent = data.total;
    } catch (e) { console.error('Visitor stats error:', e); }
  }
  setInterval(refreshVisitorStats, 10000);

  /* ===============================
     WINNER TABLE
     =============================== */
  (function() {
    const tableBody = document.querySelector('#winnerTable tbody');
    const paginationDiv = document.getElementById('pagination');
    const perPageSelect = document.getElementById('perPageSelect');
    const searchInput = document.getElementById('winnerSearch');

    let currentPage = 1;
    let perPage = 10;
    let totalRecords = 0;
    let currentSearch = '';
    let searchTimeout = null;

    function flattenGroupedWinnerData(data) {
      if (Array.isArray(data)) return data;
      if (!data || typeof data !== 'object') return [];
      return Object.keys(data).flatMap((dateKey) => {
        const rows = Array.isArray(data[dateKey]) ? data[dateKey] : [];
        return rows.map((row) => ({
          ...row,
          winner_date: row.winner_date || dateKey,
        }));
      });
    }

    function formatKM(num) {
      if (!num && num !== 0) return '—';
      if (num >= 1000000) return (num / 1000000).toFixed(2).replace(/\.00$/, '') + 'M';
      if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
      return num;
    }

    /** YYYY-MM-DD → DD-MM-YYYY (plain text; escape when inserting into HTML) */
    function formatDateDdMmYyyy(iso) {
      if (!iso || typeof iso !== 'string') return '—';
      const m = iso.match(/^(\d{4})-(\d{2})-(\d{2})/);
      if (!m) return iso;
      return `${m[3]}-${m[2]}-${m[1]}`;
    }

    /** Same date → one rowspan on Date only; rest of columns stay per row. */
    function rowsWithMergedDateColumn(rows) {
      const sorted = [...rows].sort((a, b) => {
        const cmp = String(b.winner_date || '').localeCompare(String(a.winner_date || ''));
        if (cmp !== 0) return cmp;
        return (a.chance_number || 0) - (b.chance_number || 0);
      });
      const out = [];
      let i = 0;
      while (i < sorted.length) {
        const d = sorted[i].winner_date || '';
        let j = i + 1;
        while (j < sorted.length && (sorted[j].winner_date || '') === d) {
          j++;
        }
        const rowspan = j - i;
        for (let k = i; k < j; k++) {
          out.push({
            row: sorted[k],
            dateRowspan: k === i ? rowspan : 0,
            dateLabel: k === i ? formatDateDdMmYyyy(d) : '',
          });
        }
        i = j;
      }
      return out;
    }

    function escapeHtml(str) {
      const div = document.createElement('div');
      div.appendChild(document.createTextNode(str));
      return div.innerHTML;
    }

    async function sendWinnerTableClick(winnerId) {
      const formData = new FormData();
      formData.append('winner_id', winnerId);
      formData.append('_token', document.querySelector('meta[name=csrf-token]').content);
      try {
        await fetch('{{ route("api.winner-click") }}', {
          method: 'POST',
          body: formData,
          keepalive: true,
        });
      } catch (error) {
        console.error('Winner table click error:', error);
      }
    }

    function attachWinnerLinkClickHandlers() {
      tableBody.querySelectorAll('[data-winner-link-id]').forEach(link => {
        link.addEventListener('click', async (e) => {
          e.preventDefault();
          const href = link.getAttribute('href') || '';
          const winnerId = parseInt(link.dataset.winnerLinkId, 10);
          const clicksEl = document.getElementById(`winnerTableClicks${winnerId}`);

          if (clicksEl) {
            const nextClicks = parseInt(clicksEl.dataset.clicks || '0', 10) + 1;
            clicksEl.dataset.clicks = String(nextClicks);
            clicksEl.textContent = formatKM(nextClicks);
          }

          if (!Number.isNaN(winnerId)) {
            await sendWinnerTableClick(winnerId);
          }
          if (href) {
            //window.open(href, '_blank', 'noopener,noreferrer');
            // 🔥 REDIRECT IN SAME TAB (critical fix)
            if (isMobileDevice()) {
                // Mobile → same tab (REQUIRED for timer)
                window.location.href = href;
            } else {
                // Desktop → new tab (better UX)
                window.open(href, '_blank', 'noopener,noreferrer');
            }
          }
        });
      });
    }

    async function fetchWinners() {
      try {
        const params = new URLSearchParams({ p: currentPage, limit: perPage, q: currentSearch });
        const response = await fetch(`{{ route("api.winners") }}?${params.toString()}`);
        if (!response.ok) throw new Error('Network response not ok');
        const result = await response.json();
        renderTable(flattenGroupedWinnerData(result.data));
        totalRecords = result.total;
        renderPagination();
      } catch (error) {
        console.error('Error fetching winners:', error);
        tableBody.innerHTML = '<tr><td colspan="5" class="py-4 text-red-500 text-center">Failed to load winners history.</td></tr>';
      }
    }

    function renderTable(data) {
      tableBody.innerHTML = '';
      if (!data || data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5" class="py-4 text-gray-500 text-center">No records found.</td></tr>';
        paginationDiv.innerHTML = '';
        return;
      }

      const prepared = rowsWithMergedDateColumn(data);
      prepared.forEach(({ row, dateRowspan, dateLabel }) => {
        const tr = document.createElement('tr');
        tr.className = 'border-b border-gray-700 hover:bg-[#202020] transition-colors';
        const dateTd = dateRowspan > 0
          ? `<td rowspan="${dateRowspan}" class="px-3 py-4 align-middle text-gray-300 text-xs sm:text-base whitespace-nowrap">${escapeHtml(dateLabel)}</td>`
          : '';
        tr.innerHTML = dateTd + `
          <td class="px-3 py-4 font-semibold text-gray-200 text-xs sm:text-base">${formatKM(row.total_links != null ? row.total_links : 0)}</td>
          <td class="px-3 py-4">
            <a href="${escapeHtml(row.youtube_link)}" target="_blank" data-winner-link-id="${row.id}"
               class="text-green-500 hover:text-red-500 hover:underline font-semibold text-xs sm:text-base truncate max-w-[150px] sm:max-w-xs block">
               Winner Link ${row.chance_number}
            </a>
          </td>
          <td class="px-3 py-4 font-semibold text-red-500 text-xs sm:text-base"><span id="winnerTableClicks${row.id}" data-clicks="${row.clicks}">${formatKM(row.clicks)}</span></td>
        `;
        tableBody.appendChild(tr);
      });

      attachWinnerLinkClickHandlers();
    }

    function renderPagination() {
      paginationDiv.innerHTML = '';
      const totalPages = Math.ceil(totalRecords / perPage);
      if (totalPages <= 1) return;

      const prevBtn = document.createElement('button');
      prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
      prevBtn.disabled = currentPage === 1;
      prevBtn.className = 'px-3 py-1 border border-gray-700 rounded text-gray-300 disabled:opacity-30 hover:bg-gray-700 transition-colors';
      prevBtn.onclick = async () => { if (currentPage > 1) { currentPage--; await fetchWinners(); } };
      paginationDiv.appendChild(prevBtn);

      for (let i = Math.max(1, currentPage - 1); i <= Math.min(totalPages, currentPage + 1); i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = 'px-3 py-1 border border-gray-700 rounded text-gray-300 hover:bg-gray-700 transition-colors' + (i === currentPage ? ' active-page' : '');
        const page = i;
        btn.onclick = async () => { currentPage = page; await fetchWinners(); };
        paginationDiv.appendChild(btn);
      }

      const nextBtn = document.createElement('button');
      nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
      nextBtn.disabled = currentPage === totalPages;
      nextBtn.className = 'px-3 py-1 border border-gray-700 rounded text-gray-300 disabled:opacity-30 hover:bg-gray-700 transition-colors';
      nextBtn.onclick = async () => { if (currentPage < totalPages) { currentPage++; await fetchWinners(); } };
      paginationDiv.appendChild(nextBtn);
    }

    perPageSelect.addEventListener('change', async () => {
      perPage = parseInt(perPageSelect.value, 10);
      currentPage = 1;
      await fetchWinners();
    });
    searchInput.addEventListener('input', () => {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(async () => {
        currentSearch = searchInput.value.trim();
        currentPage = 1;
        await fetchWinners();
      }, 400);
    });

    void fetchWinners();
  })();
</script>
@endsection
