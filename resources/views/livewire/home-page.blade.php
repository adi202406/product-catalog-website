<div class="bg-gray-50 dark:bg-gray-900 min-h-screen px-6 py-6">
    <div>
        <!-- Header with Logo and Search -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                
                <!-- Logo & Shop Info -->
                <div class="flex items-start gap-4 w-full lg:w-1/2">
                    <!-- Logo -->
                    @if($shopUrlLogo)
                        <div class="relative flex-shrink-0">
                            <img src="{{ $shopUrlLogo }}" alt="{{ $shopName }}" class="h-16 w-16 object-cover rounded-lg shadow-sm border border-white dark:border-gray-700">
                            <div class="absolute -bottom-1 -right-1">
                                @if($shopStatus)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-500 text-white">Buka</span>
                                @else
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white">Tutup</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="relative flex-shrink-0">
                            <div class="h-16 w-16 bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center rounded-lg shadow-sm text-white">
                                <span class="text-lg font-bold">{{ substr($shopName, 0, 1) }}</span>
                            </div>
                            <div class="absolute -bottom-1 -right-1">
                                @if($shopStatus)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-500 text-white">Buka</span>
                                @else
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white">Tutup</span>
                                @endif
                            </div>
                        </div>
                    @endif
        
                    <!-- Info -->
                    <div class="flex flex-col">
                        <h1 class="text-2xl sm:text-3xl font-bold text-indigo-700 dark:text-indigo-400">{{ $shopName }}</h1>
                        @if($shopMessage)
                        <blockquote class="mt-2 border-l-4 border-indigo-500 pl-4 italic text-sm text-gray-700 dark:text-gray-300">
                            {{ $shopMessage }}
                        </blockquote>
                    @endif
                    </div>
                </div>
        
                <!-- Search -->
                <div class="w-full lg:w-1/2">
                    <livewire:product-search />
                </div>
            </div>
        </div>

        <!-- Main Content Layout -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar - Categories -->
            <div class="w-full lg:w-52 shrink-0 flex max-md:justify-end justify-center">
                <livewire:category-list />
            </div>

            <!-- Main Product Catalog -->
            <div class="flex-1">
                <livewire:product-catalog lazy :shopStatus="$shopStatus"/>
            </div>
        </div>
    </div>
</div>
