<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @for ($i = 0; $i < $count; $i++)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        {{-- Product image placeholder --}}
        <div class="w-full h-40">
            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 animate-pulse"></div>
        </div>
        
        <div class="p-4 space-y-3">
            {{-- Product name placeholder --}}
            <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-[80%] inline-block"></div>
            <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-[18%] inline-flex"></div>
            
            {{-- Description placeholder --}}
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-1/2"></div>
            
            {{-- Size selector placeholder --}}
            <div class="flex gap-2 mt-3">
                <div class="w-20 h-6 rounded-full bg-gray-200 dark:bg-gray-700 animate-pulse"></div>
                <div class="w-20 h-6 rounded-full bg-gray-200 dark:bg-gray-700 animate-pulse"></div>
            </div>
            
            {{-- Price label placeholder --}}
            <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-1/4 mt-2"></div>
            
            {{-- Price value placeholder --}}
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded animate-pulse w-1/3"></div>
            
            {{-- Order button placeholder --}}
            <div class="w-full h-7 bg-gray-200 dark:bg-gray-700 rounded-lg animate-pulse mt-3"></div>
        </div>
    </div>
    @endfor
</div>
