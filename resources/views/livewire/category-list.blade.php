<div>
    <!-- Desktop View -->
    <div class="hidden md:block">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md p-4 border border-gray-200 dark:border-gray-700">
            <div class="mb-3 text-gray-700 dark:text-white font-bold text-sm uppercase tracking-wider">
                Kategori
            </div>
            <div class="flex flex-wrap gap-2">
                <!-- Semua produk -->
                <button wire:click="showAllProducts"
                    class="px-4 py-1.5 text-sm rounded-full transition-all duration-200 font-medium 
                    {{ $selectedCategoryId === null 
                        ? 'bg-indigo-600 text-white shadow-sm' 
                        : 'bg-gray-100 text-gray-700 hover:bg-indigo-100 dark:bg-gray-800 dark:text-white dark:hover:bg-indigo-600 dark:hover:text-white' }}">
                    Semua
                </button>

                <!-- Kategori -->
                @foreach ($categories as $category)
                    <button wire:click="selectCategory({{ $category->id }})"
                        class="px-4 py-1.5 text-sm rounded-full transition-all duration-200 font-medium flex items-center gap-2
                        {{ $selectedCategoryId == $category->id 
                            ? 'bg-indigo-600 text-white shadow-sm' 
                            : 'bg-gray-100 text-gray-700 hover:bg-indigo-100 dark:bg-gray-800 dark:text-white dark:hover:bg-indigo-600 dark:hover:text-white' }}">
                        {{ $category->name }}
                        <span class="text-xs bg-white dark:bg-indigo-800 text-indigo-600 dark:text-white px-2 py-0.5 rounded-full font-semibold shadow-sm"
                            wire:ignore>
                            {{ $category->products_count }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="relative md:hidden" x-data="{ open: false }">
        <!-- Filter Button -->
        <button @click="open = !open"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-indigo-600 text-white hover:bg-indigo-700 transition duration-200 shadow-md"
            title="Filter Kategori">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V20a1 1 0 01-1.447.894l-4-2A1 1 0 019 18v-4.586L3.293 6.707A1 1 0 013 6V4z" />
            </svg>
        </button>

        <!-- Dropdown -->
        <div x-show="open" @click.outside="open = false" x-transition
            class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-50 p-3 space-y-1">
            
            <!-- Semua produk -->
            <button wire:click="showAllProducts"
                class="w-full text-left text-sm px-3 py-2 rounded-md font-medium flex justify-between items-center transition
                {{ $selectedCategoryId === null
                    ? 'bg-indigo-600 text-white shadow-sm' 
                    : 'bg-gray-100 text-gray-700 hover:bg-indigo-100 dark:bg-gray-800 dark:text-white dark:hover:bg-indigo-600 dark:hover:text-white' }}">
                Semua
            </button>

            <!-- Kategori -->
            @foreach ($categories as $category)
                <button wire:click="selectCategory({{ $category->id }})"
                    class="w-full text-left text-sm px-3 py-2 rounded-md font-medium flex justify-between items-center transition
                    {{ $selectedCategoryId == $category->id
                        ? 'bg-indigo-600 text-white shadow-sm' 
                        : 'bg-gray-100 text-gray-700 hover:bg-indigo-100 dark:bg-gray-800 dark:text-white dark:hover:bg-indigo-600 dark:hover:text-white' }}">
                    {{ $category->name }}
                    <span
                        class="text-xs bg-white dark:bg-indigo-800 text-indigo-600 dark:text-white px-2 py-0.5 rounded-full font-semibold shadow-sm"
                            wire:ignore>
                        {{ $category->products_count }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>
</div>
