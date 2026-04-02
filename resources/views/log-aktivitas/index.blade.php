<x-app-layout>
    <x-slot name="title">Log Aktivitas</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Log Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Riwayat Aktivitas</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Total: {{ $log->count() }} Aktivitas</span>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">No</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Tanggal & Waktu
                                </th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Nama Admin</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Username</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Modul</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Aksi</th>
                                <th class="pb-3 text-gray-600 dark:text-gray-300 font-semibold">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($log as $i => $l)
                                <tr data-row class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $i + 1 }}</td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($l->created_at)->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $l->user->name }}</td>
                                    <td class="py-3 pr-4 text-gray-500 dark:text-gray-400">{{ $l->user->username }}</td>
                                    <td class="py-3 pr-4">
                                        @php
                                            $modulColor = [
                                                'kategori' =>
                                                    'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300',
                                                'alat' =>
                                                    'bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300',
                                                'peminjaman' =>
                                                    'bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300',
                                                'pengembalian' =>
                                                    'bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-300',
                                                'laporan' =>
                                                    'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300',
                                            ];
                                            $colorClass = $modulColor[$l->modul] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $colorClass }}">
                                            {{ ucfirst($l->modul) }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4">
                                        @php
                                            $aksiColor = [
                                                'tambah' =>
                                                    'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300',
                                                'ubah' =>
                                                    'bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300',
                                                'hapus' => 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300',
                                                'pengembalian' =>
                                                    'bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-300',
                                                'cetak' =>
                                                    'bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300',
                                            ];
                                            $aksiClass = $aksiColor[$l->aksi] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $aksiClass }}">
                                            {{ ucfirst($l->aksi) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-gray-700 dark:text-gray-300">{{ $l->keterangan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-400 dark:text-gray-500">
                                        Belum ada aktivitas tercatat
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    (function() {
        const ROWS_PER_PAGE = 10;
        const tbody = document.getElementById('tableBody');
        if (!tbody) return;
        const rows = Array.from(tbody.querySelectorAll('tr[data-row]'));
        if (rows.length <= ROWS_PER_PAGE) return;

        let currentPage = 1;
        const totalPages = Math.ceil(rows.length / ROWS_PER_PAGE);

        function renderPage(page) {
            currentPage = page;
            rows.forEach((row, i) => {
                row.style.display = (i >= (page - 1) * ROWS_PER_PAGE && i < page * ROWS_PER_PAGE) ? '' :
                    'none';
            });
            renderControls();
        }

        function renderControls() {
            const existing = document.getElementById('paginationBar');
            if (existing) existing.remove();

            const from = (currentPage - 1) * ROWS_PER_PAGE + 1;
            const to = Math.min(currentPage * ROWS_PER_PAGE, rows.length);

            const bar = document.createElement('div');
            bar.id = 'paginationBar';
            bar.className =
                'mt-4 px-5 pb-4 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400';
            bar.innerHTML = `
            <span>Menampilkan ${from}–${to} dari ${rows.length} data</span>
            <div id="pgBtns" class="flex gap-1"></div>`;
            tbody.closest('.overflow-x-auto').after(bar);

            const c = document.getElementById('pgBtns');
            const btnClass = 'px-3 py-1 rounded transition';
            const activeClass = 'bg-indigo-600 text-white font-semibold';
            const normalClass = 'bg-gray-100 dark:bg-gray-700 hover:bg-indigo-100 dark:hover:bg-indigo-900';
            const disabledClass = 'bg-gray-100 dark:bg-gray-700 text-gray-400 cursor-not-allowed';

            const prev = document.createElement('button');
            prev.textContent = '‹';
            prev.className = `${btnClass} ${currentPage === 1 ? disabledClass : normalClass}`;
            if (currentPage > 1) prev.onclick = () => renderPage(currentPage - 1);
            c.appendChild(prev);

            for (let p = 1; p <= totalPages; p++) {
                const btn = document.createElement('button');
                btn.textContent = p;
                btn.className = `${btnClass} ${p === currentPage ? activeClass : normalClass}`;
                btn.onclick = () => renderPage(p);
                c.appendChild(btn);
            }

            const next = document.createElement('button');
            next.textContent = '›';
            next.className = `${btnClass} ${currentPage === totalPages ? disabledClass : normalClass}`;
            if (currentPage < totalPages) next.onclick = () => renderPage(currentPage + 1);
            c.appendChild(next);
        }

        renderPage(1);
    })();
</script>
