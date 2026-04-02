@props([
    'id' => 'confirmModal',
    'title' => 'Konfirmasi',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'confirmClass' => 'bg-red-500 hover:bg-red-600',
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-4">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100">{{ $title }}</h3>
            <button onclick="closeModal('{{ $id }}')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">&times;</button>
        </div>
        <div class="p-5 space-y-4">
            {{-- Info box --}}
            <div id="{{ $id }}-info" class="bg-gray-50 dark:bg-gray-700 rounded p-3 space-y-1 text-sm hidden">
            </div>

            {{-- Pesan --}}
            <p id="{{ $id }}-message" class="text-sm text-gray-600 dark:text-gray-400"></p>

            <div class="flex gap-2 pt-2">
                <button id="{{ $id }}-confirm-btn"
                    class="text-white text-sm px-4 py-2 rounded transition {{ $confirmClass }}">
                    {{ $confirmText }}
                </button>
                <button type="button" onclick="closeModal('{{ $id }}')"
                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600
                           text-gray-700 dark:text-gray-300 text-sm px-4 py-2 rounded transition">
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</div>

@props([
    'id' => 'confirmModal',
    'title' => 'Konfirmasi',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'confirmClass' => 'bg-red-500 hover:bg-red-600',
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-4">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100">{{ $title }}</h3>
            <button onclick="closeModal('{{ $id }}')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">&times;</button>
        </div>
        <div class="p-5 space-y-4">
            <div id="{{ $id }}-info"
                class="bg-gray-50 dark:bg-gray-700 rounded p-3 space-y-1 text-sm hidden"></div>
            <p id="{{ $id }}-message" class="text-sm text-gray-600 dark:text-gray-400"></p>
            <div class="flex gap-2 pt-2">
                <button id="{{ $id }}-confirm-btn"
                    class="text-white text-sm px-4 py-2 rounded transition {{ $confirmClass }}">
                    {{ $confirmText }}
                </button>
                <button type="button" onclick="closeModal('{{ $id }}')"
                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600
                           text-gray-700 dark:text-gray-300 text-sm px-4 py-2 rounded transition">
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</div>

@once
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function confirmHapus(actionUrl, infoRows) {
            const infoBox = document.getElementById('modalHapus-info');
            const confirmBtn = document.getElementById('modalHapus-confirm-btn');

            infoBox.innerHTML = infoRows.map(([label, value]) => `
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">${label}</span>
                <span class="font-medium text-gray-800 dark:text-gray-100">${value}</span>
            </div>
        `).join('');
            infoBox.classList.remove('hidden');

            document.getElementById('modalHapus-message').textContent = 'Data yang dihapus tidak dapat dikembalikan.';

            confirmBtn.onclick = () => {
                document.getElementById('formHapus').action = actionUrl;
                document.getElementById('formHapus').submit();
            };

            openModal('modalHapus');
        }

        function confirmCetak(url, infoRows) {
            const infoBox = document.getElementById('modalCetak-info');
            const confirmBtn = document.getElementById('modalCetak-confirm-btn');

            infoBox.innerHTML = infoRows.map(([label, value]) => `
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">${label}</span>
                <span class="font-medium text-gray-800 dark:text-gray-100">${value}</span>
            </div>
        `).join('');
            infoBox.classList.remove('hidden');

            document.getElementById('modalCetak-message').textContent = 'Laporan akan diunduh dalam format PDF.';

            confirmBtn.onclick = () => {
                window.location.href = url;
                closeModal('modalCetak');
            };

            openModal('modalCetak');
        }

        function confirmCetakSemua(url) {
            const confirmBtn = document.getElementById('modalCetakSemua-confirm-btn');
            const infoBox = document.getElementById('modalCetakSemua-info');

            document.getElementById('modalCetakSemua-message').textContent =
                'Semua data peminjaman akan dicetak dalam satu file PDF.';
            infoBox.classList.add('hidden');

            confirmBtn.onclick = () => {
                window.location.href = url;
                closeModal('modalCetakSemua');
            };

            openModal('modalCetakSemua');
        }
    </script>
@endonce
