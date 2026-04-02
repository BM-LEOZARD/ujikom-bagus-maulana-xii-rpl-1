<x-app-layout>
    <x-slot name="title">Peminjaman</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Peminjaman Alat') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex justify-end">
                <button onclick="openModal('modalTambah')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded transition">
                    + Tambah Peminjaman
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Daftar Peminjam</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Total: {{ $peminjaman->count() }}
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
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $p->alat->nama_alat }}
                                    </td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $p->nama_peminjam }}</td>
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
                                    <td class="py-3 flex gap-2">
                                        @if ($p->status == 'selesai')
                                            <button disabled
                                                class="bg-yellow-200 text-white text-xs px-3 py-1 rounded cursor-not-allowed opacity-50">
                                                Edit
                                            </button>
                                            <button disabled
                                                class="bg-red-300 text-white text-xs px-3 py-1 rounded cursor-not-allowed opacity-50">
                                                Hapus
                                            </button>
                                        @else
                                            <button
                                                onclick="openEditModal(
                                                    {{ $p->id }},
                                                    {{ $p->id_alat }},
                                                    '{{ addslashes($p->nama_peminjam) }}',
                                                    '{{ $p->tgl_pinjam }}',
                                                    '{{ $p->tgl_kembali }}'
                                                )"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded transition">
                                                Edit
                                            </button>
                                            <button
                                                onclick="confirmHapus(
                                                    '{{ route('peminjaman.destroy', $p->id) }}',
                                                    [
                                                        ['Nama Alat', '{{ addslashes($p->alat->nama_alat) }}'],
                                                        ['Peminjam', '{{ addslashes($p->nama_peminjam) }}'],
                                                        ['Tgl Pinjam', '{{ $p->tgl_pinjam }}']
                                                    ]
                                                )"
                                                class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition">
                                                Hapus
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-6 text-center text-gray-400 dark:text-gray-500">
                                        Belum ada data peminjaman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <form id="formHapus" action="" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <x-confirm-modal id="modalHapus" title="Hapus Peminjaman" confirmText="Ya, Hapus"
        confirmClass="bg-red-500 hover:bg-red-600"
    />

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg mx-4 max-h-screen overflow-y-auto">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Tambah Peminjaman</h3>
                <button onclick="closeModal('modalTambah')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">&times;</button>
            </div>
            <div class="p-5">
                <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alat</label>
                        <select name="id_alat" id="tambahAlat"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            onchange="updateKondisiFromAlat(this.value)" required>
                            <option value="">-- Pilih Alat --</option>
                            @foreach ($alat as $a)
                                <option value="{{ $a->id }}" data-kondisi="{{ $a->kondisi }}"
                                    {{ old('id_alat') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama_alat }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_alat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                            Peminjam</label>
                        <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Masukkan nama peminjam" required>
                        @error('nama_peminjam')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                            Pinjam</label>
                        <input type="date" name="tgl_pinjam" value="{{ old('tgl_pinjam') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('tgl_pinjam')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                            Kembali</label>
                        <input type="date" name="tgl_kembali" value="{{ old('tgl_kembali') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('tgl_kembali')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kondisi Saat
                            Dipinjam</label>
                        <select id="tambahKondisi"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400
                                focus:outline-none cursor-not-allowed"
                            disabled>
                            <option value="">-- Pilih alat terlebih dahulu --</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                        </select>
                        <input type="hidden" name="kondisi" id="tambahKondisiHidden"
                            value="{{ old('kondisi', '') }}">
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded transition">
                            Simpan
                        </button>
                        <button type="button" onclick="closeModal('modalTambah')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600
                                   text-gray-700 dark:text-gray-300 text-sm px-4 py-2 rounded transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="modalEdit" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg mx-4 max-h-screen overflow-y-auto">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Edit Peminjaman</h3>
                <button onclick="closeModal('modalEdit')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">&times;</button>
            </div>
            <div class="p-5">
                <form id="formEdit" action="" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alat</label>
                        <select id="editAlat"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400
                                   focus:outline-none cursor-not-allowed"
                            disabled>
                            <option value="">-- Pilih Alat --</option>
                            @foreach ($peminjaman as $p)
                                <option value="{{ $p->alat->id }}">{{ $p->alat->nama_alat }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id_alat" id="editAlatHidden">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                            Peminjam</label>
                        <input type="text" id="editNamaPeminjam" name="nama_peminjam"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                            Pinjam</label>
                        <input type="date" id="editTglPinjam" name="tgl_pinjam"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                            Kembali</label>
                        <input type="date" id="editTglKembali" name="tgl_kembali"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded transition">
                            Update
                        </button>
                        <button type="button" onclick="closeModal('modalEdit')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600
                                   text-gray-700 dark:text-gray-300 text-sm px-4 py-2 rounded transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const kondisiAlat = {
            @foreach ($alat as $a)
                {{ $a->id }}: '{{ $a->kondisi }}',
            @endforeach
        };

        function updateKondisiFromAlat(idAlat) {
            const kondisiSelect = document.getElementById('tambahKondisi');
            const kondisiHidden = document.getElementById('tambahKondisiHidden');

            if (!idAlat) {
                kondisiSelect.value = '';
                kondisiHidden.value = '';
                return;
            }

            const kondisi = kondisiAlat[idAlat] ?? 'baik';
            kondisiSelect.value = kondisi;
            kondisiHidden.value = kondisi;
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(id, idAlat, namaPeminjam, tglPinjam, tglKembali) {
            document.getElementById('editAlat').value = idAlat;
            document.getElementById('editAlatHidden').value = idAlat;
            document.getElementById('editNamaPeminjam').value = namaPeminjam;
            document.getElementById('editTglPinjam').value = tglPinjam;
            document.getElementById('editTglKembali').value = tglKembali;
            document.getElementById('formEdit').action = '/peminjaman/' + id;
            openModal('modalEdit');
        }

        document.querySelectorAll('[id^="modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });

        @if ($errors->any() && !old('_method'))
            openModal('modalTambah');
        @endif
        @if ($errors->any() && old('_method') === 'PUT')
            openModal('modalEdit');
        @endif

        @if (old('id_alat'))
            updateKondisiFromAlat('{{ old('id_alat') }}');
        @endif

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
