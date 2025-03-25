<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <!-- Bagian heading dan ikon menu (placeholder) -->
    <div class="flex items-center justify-between mb-4">
        <!-- Judul Kategori -->
        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wide">
            Kategori
        </h3>
        <!-- Ikon menu (placeholder) -->
        <div class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded-md animate-pulse"></div>
    </div>
    
    <!-- Daftar kategori (placeholder) -->
    <ul class="flex flex-wrap gap-2">
        @for ($i = 0; $i < 5; $i++)
            <li>
                <!-- Chip/pill placeholder -->
                <div class="animate-pulse h-8 w-14 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
            </li>
        @endfor
    </ul>
</div>
