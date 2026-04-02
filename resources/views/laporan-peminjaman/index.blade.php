<x-app-layout>
    <x-slot name="title">Laporan Peminjaman</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Laporan Peminjaman
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex justify-end">
                <button onclick="confirmCetakSemua('{{ route('laporan-peminjaman.cetak') }}')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded transition">
                    Cetak Laporan
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Data Laporan Peminjaman</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Total: {{ $peminjaman->count() }} Laporan
                        Peminjaman</span>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">No</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Nama Alat</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Peminjam</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Tgl Pinjam</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Tgl Kembali</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Kondisi</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Status</th>
                                <th class="pb-3 text-gray-600 dark:text-gray-300 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($peminjaman as $i => $p)
                                <tr data-row class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $i + 1 }}</td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">
                                        {{ $p->alat->nama_alat }}</td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">
                                        {{ $p->nama_peminjam }}</td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $p->tgl_pinjam }}</td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $p->tgl_kembali }}</td>
                                    <td class="py-3 pr-4">
                                        @if ($p->kondisi == 'baik')
                                            <span
                                                class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 px-2 py-1 rounded text-xs">Baik</span>
                                        @else
                                            <span
                                                class="bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 px-2 py-1 rounded text-xs">Rusak</span>
                                        @endif
                                    </td>
                                    <td class="py-3 pr-4">
                                        @if ($p->status == 'belum kembali')
                                            <span
                                                class="bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300 px-2 py-1 rounded text-xs">Belum
                                                Kembali</span>
                                        @else
                                            <span
                                                class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 px-2 py-1 rounded text-xs">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if ($p->status == 'belum kembali')
                                            <span
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-400 dark:text-gray-500 text-xs px-3 py-1 rounded cursor-not-allowed">
                                                Cetak
                                            </span>
                                        @else
                                            <button
                                                onclick="confirmCetak(
                                                    '{{ route('laporan-peminjaman.cetak.satu', $p->id) }}',
                                                    [
                                                        ['Nama Alat', '{{ addslashes($p->alat->nama_alat) }}'],
                                                        ['Peminjam', '{{ addslashes($p->nama_peminjam) }}'],
                                                        ['Tgl Pinjam', '{{ $p->tgl_pinjam }}'],
                                                        ['Tgl Kembali', '{{ $p->tgl_kembali }}']
                                                    ]
                                                )"
                                                class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-3 py-1 rounded transition">
                                                Cetak
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-6 text-center text-gray-400 dark:text-gray-500">
                                        Belum ada data laporan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <x-confirm-modal id="modalCetak" title="Cetak Laporan" confirmText="Ya, Cetak"
        confirmClass="bg-indigo-500 hover:bg-indigo-600" />

    <x-confirm-modal id="modalCetakSemua" title="Cetak Semua Laporan" confirmText="Ya, Cetak Semua"
        confirmClass="bg-indigo-600 hover:bg-indigo-700" />

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

</x-app-layout>
