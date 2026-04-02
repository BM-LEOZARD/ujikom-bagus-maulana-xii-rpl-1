<x-app-layout>
    <x-slot name="title">Kategori</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex justify-end">
                <button onclick="openModal('modalTambah')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded transition">
                    + Tambah Kategori
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Daftar Kategori</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Total: {{ $kategori->count() }}
                        Kategori</span>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">No</th>
                                <th class="pb-3 pr-4 text-gray-600 dark:text-gray-300 font-semibold">Nama Kategori</th>
                                <th class="pb-3 text-gray-600 dark:text-gray-300 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($kategori as $i => $k)
                                <tr data-row class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $i + 1 }}</td>
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-300">{{ $k->nama_kategori }}</td>
                                    <td class="py-3 flex gap-2">
                                        <button
                                            onclick="openEditModal({{ $k->id }}, '{{ addslashes($k->nama_kategori) }}')"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded transition">
                                            Edit
                                        </button>
                                        <button
                                            onclick="confirmHapus(
                                                '{{ route('kategori.destroy', $k->id) }}',
                                                [['Nama Kategori', '{{ addslashes($k->nama_kategori) }}']]
                                            )"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-gray-400 dark:text-gray-500">
                                        Belum ada data kategori
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

    <x-confirm-modal id="modalHapus" title="Hapus Kategori" confirmText="Ya, Hapus"
        confirmClass="bg-red-500 hover:bg-red-600"
    />

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Tambah Kategori</h3>
                <button onclick="closeModal('modalTambah')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">&times;</button>
            </div>
            <div class="p-5">
                <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Kategori
                        </label>
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Masukkan nama kategori" required>
                        @error('nama_kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Edit Kategori</h3>
                <button onclick="closeModal('modalEdit')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">&times;</button>
            </div>
            <div class="p-5">
                <form id="formEdit" action="" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Kategori
                        </label>
                        <input type="text" id="editNamaKategori" name="nama_kategori"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('nama_kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
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
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(id, namaKategori) {
            document.getElementById('editNamaKategori').value = namaKategori;
            document.getElementById('formEdit').action = '/kategori/' + id;
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
