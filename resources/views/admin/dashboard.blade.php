@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
  <div class="space-y-10">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Dashboard Overview</h1>
        <p class="mt-1 text-gray-400">Real-time statistics and platform insights</p>
      </div>
      <div class="flex items-center gap-2 text-sm text-gray-500 bg-[#181818] px-4 py-2 rounded-lg border border-[#2a2a2a]">
        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
        System Live
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

      <!-- Live Visitors -->
      <div class="bg-[#181818] overflow-hidden rounded-2xl border border-[#2a2a2a] shadow-sm hover:border-red-500/30 transition-colors duration-300">
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-500/10 rounded-xl p-3">
              <i class="fa-solid fa-users text-red-500 text-xl"></i>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-400 truncate uppercase tracking-wider">Live Visitors</dt>
                <dd class="flex items-baseline">
                  <div class="text-3xl font-bold text-white" id="live-visitors-display">{{ $stats['live'] ?? 0 }}</div>
                  <div class="ml-2 flex items-baseline text-xs font-bold text-green-500">
                    <span class="relative flex h-2 w-2 mr-1">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    ACTIVE
                  </div>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Today's Visitors -->
      <div class="bg-[#181818] overflow-hidden rounded-2xl border border-[#2a2a2a] shadow-sm hover:border-red-500/30 transition-colors duration-300">
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500/10 rounded-xl p-3">
              <i class="fa-solid fa-calendar-day text-blue-500 text-xl"></i>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-400 truncate uppercase tracking-wider">Today's Visitors</dt>
                <dd><div class="text-3xl font-bold text-white">{{ $stats['today'] ?? 0 }}</div></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Visitors -->
      <div class="bg-[#181818] overflow-hidden rounded-2xl border border-[#2a2a2a] shadow-sm hover:border-red-500/30 transition-colors duration-300">
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500/10 rounded-xl p-3">
              <i class="fa-solid fa-chart-line text-green-500 text-xl"></i>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-400 truncate uppercase tracking-wider">Total Visitors</dt>
                <dd class="flex items-center justify-between">
                  <div class="text-3xl font-bold text-white" id="total-visitors-display">{{ $stats['total'] ?? 0 }}</div>
                  <button onclick="editTotalVisitors({{ $stats['total'] ?? 0 }})" class="text-gray-600 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/5" title="Edit Total Visitors">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                  </button>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Past Day Winner: minimum wait (seconds) -->
    <div class="bg-[#181818] rounded-2xl border border-[#2a2a2a] p-6 shadow-sm">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h2 class="text-lg font-bold text-white">Pastday Winner Video Watch Time</h2>
          <p class="mt-1 text-sm text-gray-400">
            Minimum seconds a visitor must stay away (after opening the winner link) before the submit fields unlock.
            Current: <span id="min-view-seconds-display" class="text-red-400 font-semibold">{{ (int) ($minViewSeconds ?? 5) }}</span> s
          </p>
        </div>
        <div class="flex flex-wrap items-end gap-3">
          <div>
            <label for="min-view-seconds-input" class="block text-xs font-medium text-gray-500 mb-1">Seconds</label>
            <input type="number" id="min-view-seconds-input" min="1" max="3600" step="1"
              value="{{ (int) ($minViewSeconds ?? 5) }}"
              class="w-28 bg-[#0f0f0f] text-white text-sm rounded-lg border border-[#3a3a3a] focus:border-red-500 outline-none py-2.5 px-3">
          </div>
          <button type="button" onclick="saveMinViewSeconds()"
            class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 transition-colors">
            Save
          </button>
        </div>
      </div>
    </div>

    <!-- Fallback “Past Day Winner” links (when no winner row for that chance) -->
    <div class="bg-[#181818] rounded-2xl border border-[#2a2a2a] p-6 shadow-sm">
      <div class="mb-4">
        <h2 class="text-lg font-bold text-white">Fallback winner links (6 chances)</h2>
        <p class="mt-1 text-sm text-gray-400">
          Used on the home page when there is no past-day winner for that chance. Each chance can have its own URL.
        </p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach(range(1, 6) as $c)
          <div>
            <label for="fallback-link-{{ $c }}" class="block text-xs font-medium text-gray-500 mb-1">Chance {{ $c }}</label>
            <input type="url" id="fallback-link-{{ $c }}" name="fallback_link_{{ $c }}"
              value="{{ e($fallbackWinnerLinks[$c] ?? \App\Models\UtyoubeSetting::DEFAULT_FALLBACK_YOUTUBE) }}"
              class="block w-full bg-[#0f0f0f] text-white text-sm rounded-lg border border-[#3a3a3a] focus:border-red-500 outline-none py-2.5 px-3"
              placeholder="https://...">
          </div>
        @endforeach
      </div>
      <div class="mt-5 flex justify-end">
        <button type="button" onclick="saveFallbackWinnerLinks()"
          class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 transition-colors">
          Save fallback links
        </button>
      </div>
    </div>

    <!-- Winners History Table -->
    <div class="bg-[#181818] rounded-2xl border border-[#2a2a2a] overflow-hidden shadow-sm">
      <div class="px-6 py-5 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-[#212121]/50 border-b border-[#2a2a2a] gap-4">
        <div>
          <h3 class="text-xl font-bold text-white">Winner History</h3>
          <p class="mt-1 text-sm text-gray-400">Manage recent winners and their performance.</p>
        </div>
        <button onclick="openAddWinnerModal()" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-lg shadow-red-900/20 text-white bg-red-600 hover:bg-red-700 focus:outline-none transition-all duration-200 active:scale-95 whitespace-nowrap">
          <i class="fa-solid fa-plus mr-2"></i> Add Winner
        </button>
      </div>

      <div class="flex flex-col sm:flex-row gap-3 w-full px-2 py-4">
        <form onsubmit="searchWinners(event)" class="relative flex-1" method="GET">
          <input type="text" name="q" id="search-input" value="{{ request('q') }}" oninput="toggleClearButton(this)" placeholder="Search by date or link..." class="bg-[#0f0f0f] text-white text-sm rounded-lg border-0 focus:border focus:border-red-500 outline-0 block w-full py-3 pr-24 pl-3 shadow-sm">
          <button type="button" id="clear-search-btn" onclick="clearSearch()" class="absolute right-10 top-1 bottom-1 px-3 text-gray-500 hover:text-white transition-colors {{ request('q') ? '' : 'hidden' }}">
            <i class="fa-solid fa-xmark"></i>
          </button>
          <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 bg-red-600 text-white text-xs font-bold rounded-md hover:bg-red-700 transition-colors shadow-lg shadow-red-900/20">
            <i class="fa-solid fa-search"></i>
          </button>
        </form>
      </div>
    </div>

    <!-- Add Winner Modal -->
    <div id="add-winner-modal" class="hidden fixed inset-0 z-50">
      <div class="absolute inset-0 bg-black/70" onclick="closeAddWinnerModal()"></div>
      <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-3xl bg-[#181818] rounded-2xl border border-[#2a2a2a] shadow-2xl">
          <div class="px-6 py-4 border-b border-[#2a2a2a] flex items-center justify-between">
            <h3 class="text-lg font-bold text-white">Add Winner</h3>
            <button type="button" onclick="closeAddWinnerModal()" class="text-gray-400 hover:text-white transition-colors">
              <i class="fa-solid fa-xmark text-lg"></i>
            </button>
          </div>

          <form id="add-winner-form" onsubmit="submitWinnerHistory(event)" class="p-6 grid grid-cols-1 gap-5 sm:grid-cols-2" novalidate>
            <div id="add-winner-form-error" class="hidden sm:col-span-2 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400"></div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-2">Winner Date</label>
              <input
                id="add-winner-date"
                type="text"
                name="date"
                required
                max="{{ date('Y-m-d') }}"
                placeholder="Select Date"
                onfocus="openWinnerDatePicker(this)"
                onclick="openWinnerDatePicker(this)"
                onblur="if(!this.value){this.type='text'}"
                class="block w-full bg-[#0f0f0f] border border-[#3a3a3a] rounded-lg text-white shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm h-11 px-4"
              >
              <p data-error-for="date" class="hidden mt-2 text-xs text-red-400"></p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-2">Chance Number</label>
              <select name="chance_number" required class="block w-full bg-[#0f0f0f] border border-[#3a3a3a] rounded-lg text-white shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm h-11 px-4">
                <option value="">Select Chance</option>
                <option value="1">Chance 1</option>
                <option value="2">Chance 2</option>
                <option value="3">Chance 3</option>
                <option value="4">Chance 4</option>
                <option value="5">Chance 5</option>
                <option value="6">Chance 6</option>
              </select>
              <p data-error-for="chance_number" class="hidden mt-2 text-xs text-red-400"></p>
            </div>

            <div class="sm:col-span-2">
              <label class="block text-sm font-semibold text-gray-300 mb-2">YouTube Link</label>
              <input type="url" name="link" required placeholder="https://youtube.com/..." class="block w-full bg-[#0f0f0f] border border-[#3a3a3a] rounded-lg text-white shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm h-11 px-4">
              <p data-error-for="link" class="hidden mt-2 text-xs text-red-400"></p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-2">Total links (selection pool)</label>
              <input type="number" name="total_links" required value="0" min="0" step="1" class="block w-full bg-[#0f0f0f] border border-[#3a3a3a] rounded-lg text-white shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm h-11 px-4">
              <p data-error-for="total_links" class="hidden mt-2 text-xs text-red-400"></p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-2">Submissions (Past Day Winner)</label>
              <input type="number" name="submissions" required value="0" min="0" step="1" class="block w-full bg-[#0f0f0f] border border-[#3a3a3a] rounded-lg text-white shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm h-11 px-4">
              <p data-error-for="submissions" class="hidden mt-2 text-xs text-red-400"></p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-2">Clicks</label>
              <input type="number" name="clicks" required value="0" min="0" step="1" class="block w-full bg-[#0f0f0f] border border-[#3a3a3a] rounded-lg text-white shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm h-11 px-4">
              <p data-error-for="clicks" class="hidden mt-2 text-xs text-red-400"></p>
            </div>

            <div class="sm:col-span-2 flex items-center justify-end gap-3 pt-2">
              <button type="button" onclick="closeAddWinnerModal()" class="inline-flex items-center px-5 py-2.5 text-sm font-bold rounded-lg border border-[#3a3a3a] text-gray-300 hover:text-white hover:border-[#4a4a4a] transition-colors">
                Cancel
              </button>
              <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-bold rounded-lg text-white bg-red-600 hover:bg-red-700 transition-colors">
                Save Winner
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto rounded-2xl rounded-b-none">
      <table class="min-w-full divide-y divide-[#2a2a2a] winners-table-vertical-lines">
        <thead class="bg-[#212121]/30">
          <tr>
            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Date</th>
            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">YouTube Link</th>
            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Total links Submitted</th>
            <!-- <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Submissions</th> -->
            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Clicks</th>
          </tr>
        </thead>
        <tbody id="winners-table-body" class="divide-y divide-[#2a2a2a]">
          <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">Loading...</td></tr>
        </tbody>
      </table>
    </div>

    <div id="winners-pagination" class="rounded-2xl overflow-x-auto rounded-t-none"></div>

  </div>
</main>
@endsection

@section('scripts')
<script>
  let currentPage = {{ request('p', 1) }};
  let currentLimit = {{ request('limit', 24) }};
  let currentSearch = "{{ addslashes(request('q', '')) }}";

  document.addEventListener('DOMContentLoaded', () => {
    fetchWinners(currentPage, currentLimit, currentSearch);
  });

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

  function fetchWinners(page = 1, limit = 24, search = '') {
    currentPage = page;
    currentLimit = limit;
    currentSearch = search;

    const tbody = document.getElementById('winners-table-body');
    tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">Loading...</td></tr>';

    const url = `{{ route('admin.api.winners') }}?p=${page}&limit=${limit}&q=${encodeURIComponent(search)}`;

    fetch(url)
      .then(res => res.json())
      .then(data => {
        renderTable(flattenGroupedWinnerData(data.data));
        renderPagination(data.total, data.limit, data.page);
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('p', page);
        newUrl.searchParams.set('limit', limit);
        if (search) newUrl.searchParams.set('q', search);
        else newUrl.searchParams.delete('q');
        window.history.pushState({}, '', newUrl);
      })
      .catch(() => {
        tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-red-500 italic">Error loading data.</td></tr>';
      });
  }

  function formatDateDdMmYyyy(iso) {
    if (!iso || typeof iso !== 'string') return '—';
    const m = iso.match(/^(\d{4})-(\d{2})-(\d{2})/);
    if (!m) return iso;
    return `${m[3]}-${m[2]}-${m[1]}`;
  }

  function rowsWithMergedDateColumn(winners) {
    const sorted = [...winners].sort((a, b) => {
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
          winner: sorted[k],
          dateRowspan: k === i ? rowspan : 0,
          dateLabel: k === i ? formatDateDdMmYyyy(d) : '',
        });
      }
      i = j;
    }
    return out;
  }

  function renderTable(winners) {
    const tbody = document.getElementById('winners-table-body');
    if (!winners || winners.length === 0) {
      tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">No winner history records found.</td></tr>';
      return;
    }
    const prepared = rowsWithMergedDateColumn(winners);
    tbody.innerHTML = prepared.map(({ winner, dateRowspan, dateLabel }) => {
      const dateTd = dateRowspan > 0
        ? `<td rowspan="${dateRowspan}" class="px-6 py-5 align-middle whitespace-nowrap text-sm font-bold text-white">${escapeHtml(dateLabel)}</td>`
        : '';
      return `
      <tr class="hover:bg-[#212121]/50 transition-colors group">
        ${dateTd}
        <td class="px-6 py-5 whitespace-nowrap text-sm">
          <div class="flex items-center space-x-3">
            <a href="${escapeHtml(winner.youtube_link)}" target="_blank" class="text-red-500 hover:text-red-400 hover:underline transition-color truncate max-w-xs block font-medium">
              ${escapeHtml(winner.youtube_link)}
            </a>
            <button onclick="editWinnerLink(${winner.id}, '${winner.youtube_link.replace(/'/g, "\\'")}')" class="text-gray-600 hover:text-white transition-colors p-1 opacity-0 group-hover:opacity-100" title="Edit Link">
              <i class="fa-solid fa-pen text-xs"></i>
            </button>
          </div>
        </td>
        <td class="px-6 py-5 whitespace-nowrap text-sm text-center">
          <div class="flex items-center justify-center space-x-2">
            <span class="text-amber-200/90 font-medium">${formatNumber(winner.total_links != null ? winner.total_links : 0)}</span>
            <button onclick="editWinnerTotalLinks(${winner.id}, ${winner.total_links != null ? winner.total_links : 0})" class="text-gray-600 hover:text-white transition-colors p-1 opacity-0 group-hover:opacity-100" title="Edit pool size (links in draw)">
              <i class="fa-solid fa-pen text-[10px]"></i>
            </button>
          </div>
        </td>
        
        <td class="px-6 py-5 whitespace-nowrap text-sm text-center">
          <div class="flex items-center justify-center space-x-3">
            <span id="clicks-display-${winner.id}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-500 border border-green-500/20">
              ${formatNumber(winner.clicks)} Clicks
            </span>
            <button onclick="editWinnerClicks(${winner.id}, ${winner.clicks}, 'clicks-display-${winner.id}')" class="text-gray-600 hover:text-white transition-colors p-1 opacity-0 group-hover:opacity-100">
              <i class="fa-solid fa-pen text-xs"></i>
            </button>
          </div>
        </td>
      </tr>
    `;
    }).join('');
  }

  function renderPagination(total, limit, page) {
    const totalPages = Math.ceil(total / limit);
    const container = document.getElementById('winners-pagination');
    if (totalPages <= 1) { container.innerHTML = ''; return; }

    const start = (page - 1) * limit + 1;
    const end = Math.min((page - 1) * limit + limit, total);

    let html = `<div class="px-6 py-4 border-t border-[#2a2a2a] bg-[#212121]/30 flex flex-col sm:flex-row justify-between items-center gap-4">
      <span class="text-sm text-gray-400">Showing <span class="font-semibold text-white">${start}</span> to <span class="font-semibold text-white">${end}</span> of <span class="font-semibold text-white">${total}</span> results</span>
      <div class="inline-flex -space-x-px rounded-md shadow-sm isolate">`;

    if (page > 1) {
      html += `<button onclick="fetchWinners(${page-1},${limit},'${currentSearch}')" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-[#3a3a3a] hover:bg-[#2a2a2a]"><i class="fa-solid fa-chevron-left"></i></button>`;
    } else {
      html += `<span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-600 ring-1 ring-inset ring-[#2a2a2a] cursor-not-allowed"><i class="fa-solid fa-chevron-left"></i></span>`;
    }
    for (let i = 1; i <= totalPages; i++) {
      if (i === page) {
        html += `<span class="relative z-10 inline-flex items-center bg-red-600 px-4 py-2 text-sm font-semibold text-white">${i}</span>`;
      } else {
        html += `<button onclick="fetchWinners(${i},${limit},'${currentSearch}')" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-400 ring-1 ring-inset ring-[#3a3a3a] hover:bg-[#2a2a2a]">${i}</button>`;
      }
    }
    if (page < totalPages) {
      html += `<button onclick="fetchWinners(${page+1},${limit},'${currentSearch}')" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-[#3a3a3a] hover:bg-[#2a2a2a]"><i class="fa-solid fa-chevron-right"></i></button>`;
    } else {
      html += `<span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-600 ring-1 ring-inset ring-[#2a2a2a] cursor-not-allowed"><i class="fa-solid fa-chevron-right"></i></span>`;
    }
    html += `</div></div>`;
    container.innerHTML = html;
  }

  function searchWinners(event) {
    event.preventDefault();
    const q = document.getElementById('search-input').value;
    fetchWinners(1, currentLimit, q);
  }

  function toggleClearButton(input) {
    const btn = document.getElementById('clear-search-btn');
    if (input.value.trim().length > 0) btn.classList.remove('hidden');
    else btn.classList.add('hidden');
  }

  function clearSearch() {
    const input = document.getElementById('search-input');
    input.value = '';
    toggleClearButton(input);
    fetchWinners(1, currentLimit, '');
  }

  function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
  }

  function formatNumber(num) {
    num = Number(num);
    if (num >= 1e9) return (num/1e9).toFixed(1) + 'B';
    if (num >= 1e6) return (num/1e6).toFixed(1) + 'M';
    if (num >= 1e3) return (num/1e3).toFixed(1) + 'K';
    return num.toString();
  }

  function editTotalVisitors(current) {
    const val = prompt("Enter new Total Visitors count:", current);
    if (val !== null && val !== "" && !isNaN(val)) {
      updateStat('update_total_visitors', {total: val}, 'total-visitors-display', formatNumber(val));
    }
  }

  async function saveMinViewSeconds() {
    const input = document.getElementById('min-view-seconds-input');
    const seconds = parseInt(input.value, 10);
    if (Number.isNaN(seconds) || seconds < 1 || seconds > 3600) {
      alert('Enter a whole number between 1 and 3600 seconds.');
      return;
    }

    const formData = new FormData();
    formData.append('action', 'update_min_view_seconds');
    formData.append('seconds', String(seconds));
    formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

    try {
      const result = await postAdminAjax(formData);
      if (result.success) {
        const saved = typeof result.seconds !== 'undefined' ? result.seconds : seconds;
        const display = document.getElementById('min-view-seconds-display');
        if (display) display.textContent = saved;
        input.value = saved;
      } else {
        alert('Error: ' + (result.message || 'Could not save.'));
      }
    } catch (error) {
      alert(error.message || 'An unexpected error occurred.');
    }
  }

  async function saveFallbackWinnerLinks() {
    const formData = new FormData();
    formData.append('action', 'update_fallback_winner_links');
    formData.append('_token', document.querySelector('meta[name=csrf-token]').content);
    for (let c = 1; c <= 6; c++) {
      const el = document.getElementById('fallback-link-' + c);
      formData.append('fallback_link_' + c, el ? el.value.trim() : '');
    }

    try {
      const result = await postAdminAjax(formData);
      if (result.success && result.links) {
        for (let c = 1; c <= 6; c++) {
          const el = document.getElementById('fallback-link-' + c);
          const url = result.links[c] ?? result.links[String(c)];
          if (el && url) el.value = url;
        }
        alert('Fallback links saved.');
      } else {
        alert('Error: ' + (result.message || 'Could not save.'));
      }
    } catch (error) {
      if (error?.type === 'validation' && error.errors) {
        const first = Object.values(error.errors).flat()[0];
        alert(first || error.message || 'Validation failed.');
        return;
      }
      alert(error.message || 'An unexpected error occurred.');
    }
  }

  function editWinnerClicks(id, current, displayId) {
    const val = prompt("Enter new Click count:", current);
    if (val !== null && val !== "" && !isNaN(val)) {
      updateStat('update_winner', {id, clicks: val}, displayId, formatNumber(val));
    }
  }

  function editWinnerLink(id, current) {
    const val = prompt("Enter new YouTube Link:", current);
    if (val !== null && val !== "" && val !== current) {
      updateStat('update_winner', {id, link: val}, null, null);
    }
  }

  function editWinnerSubmissions(id, current) {
    const val = prompt("Submissions (Past Day Winner link — user submits):", current);
    if (val !== null && val !== "" && !isNaN(val)) {
      updateStat('update_winner', {id, submissions: val}, null, null);
    }
  }

  function editWinnerTotalLinks(id, current) {
    const val = prompt("Total links (pool size used for selection):", current);
    if (val !== null && val !== "" && !isNaN(val)) {
      updateStat('update_winner', {id, total_links: val}, null, null);
    }
  }

  function openAddWinnerModal() {
    document.getElementById('add-winner-modal').classList.remove('hidden');

    const dateInput = document.getElementById('add-winner-date');
    if (dateInput) {
      setTimeout(() => {
        openWinnerDatePicker(dateInput);
      }, 100);
    }
  }

  function closeAddWinnerModal() {
    document.getElementById('add-winner-modal').classList.add('hidden');
  }

  function openWinnerDatePicker(input) {
    if (!input) {
      return;
    }

    input.type = 'date';

    if (typeof input.showPicker === 'function') {
      try {
        input.showPicker();
      } catch (e) {
        // Some browsers block showPicker until direct user interaction.
      }
    }
  }

  async function postAdminAjax(formData) {
    const response = await fetch('{{ route("admin.ajax-update") }}', {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: formData,
    });

    if (response.redirected) {
      throw new Error('Request was redirected. Your admin session may have expired. Please log in again.');
    }

    const contentType = response.headers.get('content-type') || '';
    const payload = contentType.includes('application/json')
      ? await response.json()
      : { message: await response.text() };

    if (!response.ok) {
      if (response.status === 422 && payload.errors) {
        throw {
          type: 'validation',
          message: payload.message || 'Validation failed.',
          errors: payload.errors,
        };
      }

      if (response.status === 401) {
        throw new Error('You are not authenticated. Please log in again.');
      }

      if (response.status === 419) {
        throw new Error('Your session expired. Refresh the page and try again.');
      }

      throw new Error(payload.message || 'Request failed.');
    }

    return payload;
  }

  function clearAddWinnerErrors() {
    const form = document.getElementById('add-winner-form');
    if (!form) {
      return;
    }

    const formError = document.getElementById('add-winner-form-error');
    if (formError) {
      formError.textContent = '';
      formError.classList.add('hidden');
    }

    form.querySelectorAll('[data-error-for]').forEach((node) => {
      node.textContent = '';
      node.classList.add('hidden');
    });

    form.querySelectorAll('input, select').forEach((field) => {
      field.classList.remove('border-red-500');
      field.classList.add('border-[#3a3a3a]');
    });
  }

  function showAddWinnerErrors(errors, fallbackMessage = 'Please correct the highlighted fields.') {
    const form = document.getElementById('add-winner-form');
    const formError = document.getElementById('add-winner-form-error');

    clearAddWinnerErrors();

    if (formError) {
      formError.textContent = fallbackMessage;
      formError.classList.remove('hidden');
    }

    Object.entries(errors || {}).forEach(([fieldName, messages]) => {
      const input = form?.querySelector(`[name="${fieldName}"]`);
      const errorNode = form?.querySelector(`[data-error-for="${fieldName}"]`);
      const message = Array.isArray(messages) ? messages[0] : messages;

      if (input) {
        input.classList.remove('border-[#3a3a3a]');
        input.classList.add('border-red-500');
      }

      if (errorNode) {
        errorNode.textContent = message;
        errorNode.classList.remove('hidden');
      }
    });
  }

  function submitWinnerHistory(event) {
    event.preventDefault();
    const form = event.target;
    clearAddWinnerErrors();
    const formData = new FormData(form);

    const chanceNumber = formData.get('chance_number');
    if (!chanceNumber) {
      showAddWinnerErrors({ chance_number: ['Please select a chance number.'] });
      return;
    }

    formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

    postAdminAjax(formData)
      .then(result => {
        if (result.success) {
          fetchWinners(currentPage, currentLimit, currentSearch);
          closeAddWinnerModal();
          form.reset();
          clearAddWinnerErrors();
          alert("Winner history added successfully.");
        } else {
          alert('Error: ' + (result.message || 'Unknown error'));
        }
      })
      .catch((error) => {
        if (error?.type === 'validation') {
          showAddWinnerErrors(error.errors, error.message);
          return;
        }

        const formError = document.getElementById('add-winner-form-error');
        if (formError) {
          formError.textContent = error.message || 'An unexpected error occurred.';
          formError.classList.remove('hidden');
        }
      });
  }

  function updateStat(action, data, displayId, formattedValue) {
    const formData = new FormData();
    formData.append('action', action);
    formData.append('_token', document.querySelector('meta[name=csrf-token]').content);
    for (const key in data) formData.append(key, data[key]);

    postAdminAjax(formData)
      .then(result => {
        if (result.success) {
          if (displayId && formattedValue) {
            const el = document.getElementById(displayId);
            if (el) {
              el.textContent = formattedValue;
              el.classList.add('text-indigo-400');
              setTimeout(() => el.classList.remove('text-indigo-400'), 1000);
            }
          }
          fetchWinners(currentPage, currentLimit, currentSearch);
        } else {
          alert('Error: ' + (result.message || 'Unknown error'));
        }
      })
      .catch((error) => alert(error.message || 'An unexpected error occurred.'));
  }
</script>
@endsection
