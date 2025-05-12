<div 
    x-data="{ focused: false }" 
    class="fixed top-5 right-0 lg:right-16  sm z-50 w-full flex justify-end px-4 sm:px-8"
>
    <div 
        :class="focused ? 'w-[85vw] sm:w-[600px]' : 'w-14 sm:w-[500px]'" 
        class="transition-all duration-300 ease-in-out overflow-hidden rounded-2xl border border-gray-400 backdrop-blur-md bg-white/60 dark:bg-gray-800/60 flex items-center"
        @click="focused = true"
        @click.away="focused = false"
    >
        <!-- Icon Search -->
        <div class="flex items-center justify-center pl-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Input Text -->
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search"
            x-show="focused || window.innerWidth >= 640"
            x-transition
            class="w-full py-3 px-4 outline-none text-base sm:text-lg text-gray-800 dark:text-gray-100 placeholder-gray-400 bg-transparent"
            placeholder="Cari produk..." 
            @focus="focused = true"
        />

        <!-- Tombol Clear -->
        @if ($search)
            <button 
                wire:click="clearSearch" 
                class="flex items-center justify-center px-4 h-full focus:outline-none hover:bg-gray-100 dark:hover:bg-gray-700"
                aria-label="Hapus pencarian"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    <!-- Spinner -->
    <div wire:loading wire:target="search" class="absolute right-10 top-3.5">
        <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>
