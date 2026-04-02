<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-full">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">

        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px:6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} copyright - By Bagus Maulana XII RPL 1. All rights reserved.
                </p>
            </div>
        </footer>

    </div>

    {{-- Toast Container --}}
    <div id="toast-container" class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

    <script>
        function showToast(type, message) {
            const configs = {
                success: {
                    bg: 'bg-green-500',
                    icon: `<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
                },
                error: {
                    bg: 'bg-red-500',
                    icon: `<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
                },
                warning: {
                    bg: 'bg-yellow-400',
                    icon: `<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`,
                },
                info: {
                    bg: 'bg-blue-500',
                    icon: `<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/></svg>`,
                },
            };

            const {
                bg,
                icon
            } = configs[type] ?? configs.info;
            const container = document.getElementById('toast-container');

            const toast = document.createElement('div');
            toast.className = [
                'pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-white text-sm max-w-sm w-full',
                bg,
                'translate-x-full opacity-0 transition-all duration-300 ease-out'
            ].join(' ');

            toast.innerHTML = `
                ${icon}
                <span class="flex-1">${message}</span>
                <button onclick="removeToast(this.parentElement)" class="ml-2 opacity-70 hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    toast.classList.remove('translate-x-full', 'opacity-0');
                });
            });

            setTimeout(() => removeToast(toast), 3500);
        }

        function removeToast(toast) {
            if (!toast || toast._removing) return;
            toast._removing = true;
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }
    </script>

    @if (session('success'))
        <script>
            showToast('success', '{{ session('success') }}')
        </script>
    @endif
    @if (session('error'))
        <script>
            showToast('error', '{{ session('error') }}')
        </script>
    @endif
    @if (session('warning'))
        <script>
            showToast('warning', '{{ session('warning') }}')
        </script>
    @endif
    @if (session('info'))
        <script>
            showToast('info', '{{ session('info') }}')
        </script>
    @endif
    @if (session('status') === 'profile-updated')
        <script>
            showToast('success', 'Profile berhasil diperbarui.')
        </script>
    @endif
    @if (session('status') === 'password-updated')
        <script>
            showToast('success', 'Password berhasil diperbarui.')
        </script>
    @endif

</body>

</html>
