<div class="bg-gray-50 dark:bg-gray-900 min-h-screen px-6 py-6">
    <div>
        <!-- Header with Logo and Search -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">

                <!-- Logo & Shop Info -->
                <div class="flex items-start gap-4 w-full lg:w-1/2">
                    <!-- Logo -->
                    @if ($shopUrlLogo)
                        <div class="relative flex-shrink-0">
                            <img src="{{ $shopUrlLogo }}" alt="{{ $shopName }}"
                                class="h-16 w-16 object-cover rounded-lg shadow-sm border border-white dark:border-gray-700">
                            <div class="absolute -bottom-1 -right-1">
                                @if ($shopStatus)
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-500 text-white">Buka</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white">Tutup</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="relative flex-shrink-0">
                            <div
                                class="h-16 w-16 bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center rounded-lg shadow-sm text-white">
                                <span class="text-lg font-bold">{{ substr($shopName, 0, 1) }}</span>
                            </div>
                            <div class="absolute -bottom-1 -right-1">
                                @if ($shopStatus)
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-500 text-white">Buka</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white">Tutup</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Info -->
                    <div class="flex flex-col">
                        <h1 class="text-2xl sm:text-3xl font-bold text-indigo-700 dark:text-indigo-400">
                            {{ $shopName }}</h1>
                        @if ($shopMessage)
                            <blockquote
                                class="mt-2 border-l-4 border-indigo-500 pl-4 italic text-sm text-gray-700 dark:text-gray-300">
                                {{ $shopMessage }}
                            </blockquote>
                        @endif
                    </div>
                </div>

                <!-- Search -->
                <!-- Search and Queue Button Section -->
                <div class="w-full flex flex-col lg:flex-row gap-2">
                    <!-- Search Bar -->
                    <div class="relative w-full">
                        <livewire:product-search />
                    </div>

                    <!-- Lihat Antrian Button -->
                    <div x-data="{ showQueueModal: false, tooltip: false }"
                        class="fixed top-18 lg:top-5 right-0 w-full flex justify-end px-4 sm:px-8 z-20">
                        <button @click="showQueueModal = true" @mouseenter="tooltip = true"
                            @mouseleave="tooltip = false"
                            class="relative lg:w-auto h-10 lg:h-14 bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center px-4 rounded-xl transition">

                            <!-- Icon for desktop -->
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                                </svg>
                            </span>

                            <!-- Tooltip (visible only on desktop) -->
                            <!-- Tooltip (visible on all devices) -->
                            <div x-show="tooltip" x-transition
                                class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-max bg-gray-800 text-white text-xs rounded px-2  shadow-lg z-50">
                                Lihat Antrian
                            </div>

                        </button>

                        <!-- Modal -->
                        <template x-teleport="body">
                            <div x-show="showQueueModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                                <div class="fixed inset-0 bg-black/50 transition-opacity"></div>
                                <div class="flex min-h-screen items-center justify-center p-4">
                                    <div @click.away="showQueueModal = false"
                                        class="relative bg-white dark:bg-[#0D1321] rounded-xl shadow-lg w-full max-w-2xl p-6 transition-all">
                                        <!-- Close -->
                                        <button @click="showQueueModal = false"
                                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Daftar
                                            Antrian Hari Ini</h2>
                                        <livewire:queue-list-today />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div id="purchase-popup"
            class="fixed bottom-4 right-4 bg-white border border-gray-300 shadow-lg rounded-xl p-4 max-w-xs z-50 animate-slide-in hidden">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-500 mr-2 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m0-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                </svg>
                <div class="text-sm text-gray-800">
                    <strong>Info:</strong><br>
                    Untuk saat ini, pembelian melalui website belum tersedia. Silakan kunjungi toko kami untuk pembelian
                    secara offline.
                </div>
            </div>
            <button onclick="document.getElementById('purchase-popup').classList.add('hidden')"
                class="absolute top-1 right-2 text-gray-400 hover:text-gray-700">
                &times;
            </button>
        </div>

        <!-- Main Content Layout -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar - Categories -->
            <div class="w-full lg:w-52 shrink-0 flex max-md:justify-end justify-center">
                <livewire:category-list />
            </div>

            <!-- Main Product Catalog -->
            <div class="flex-1">
                <livewire:product-catalog lazy :shopStatus="$shopStatus" />
            </div>
        </div>

        <!-- Optional: Animasi Masuk -->
        <style>
            @keyframes slide-in {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-slide-in {
                animation: slide-in 0.3s ease-out;
            }
        </style>

        <!-- Script to show popup on page load -->
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const popup = document.getElementById('purchase-popup');
                popup.classList.remove('hidden');
            });
        </script>
    </div>
</div>
