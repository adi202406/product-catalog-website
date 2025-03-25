<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Product Grid -->
    <div class="container mx-auto">
        <!-- Display search/filter information if needed -->
        @if (!empty($searchQuery))
            <div class="mb-4">
                <p class="text-gray-600 dark:text-gray-300">
                    Hasil pencarian untuk: <span class="font-medium">"{{ $searchQuery }}"</span>
                    @if ($selectedCategoryId)
                        dalam kategori yang dipilih
                    @endif
                </p>
            </div>
        @endif

        @if ($products->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-500 mx-auto mb-4"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">Tidak ada produk ditemukan</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    @if (!empty($searchQuery) && $selectedCategoryId)
                        Coba ubah kata kunci pencarian atau pilih kategori yang berbeda.
                    @elseif (!empty($searchQuery))
                        Coba ubah kata kunci pencarian atau jelajahi semua kategori.
                    @elseif ($selectedCategoryId)
                        Kategori ini belum memiliki produk.
                    @else
                        Tidak ada produk tersedia saat ini.
                    @endif
                </p>
            </div>
        @else
            <!-- Changed from 3 columns to 4 columns -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    @php
                        $firstTypeId = $product->types->first()->id ?? null;
                    @endphp
                    <div x-data="{
                        activeTypeId: {{ $firstTypeId ?? 'null' }},
                        activeTypeIndex: 0,
                        currentImageIndex: 0,
                        productImages: [],
                        isShopClosed: {{ $shopStatus == false ? 'true' : 'false' }},
                    
                        changeType(typeId, index) {
                            this.activeTypeId = typeId;
                            this.activeTypeIndex = index;
                            this.currentImageIndex = 0;
                    
                            // Check if images are already loaded in the backend
                            if ($wire.typeImagesMap[typeId]) {
                                this.productImages = $wire.typeImagesMap[typeId];
                            } else {
                                // Otherwise load them
                                this.productImages = [];
                                $wire.loadTypeImages(typeId);
                            }
                        },
                    
                        // Preload types for better user experience
                        preloadTypes() {
                            @foreach ($product->types as $type)
                                    this.$nextTick(() => {
                                        $wire.preloadTypeImages({{ $type->id }});
                                    }); @endforeach
                        },
                    
                        // Initialize images on load
                        initializeImages(typeId) {
                            if (typeId && $wire.typeImagesMap[typeId]) {
                                this.productImages = $wire.typeImagesMap[typeId];
                            } else if (typeId) {
                                $wire.loadTypeImages(typeId).then(() => {
                                    if ($wire.typeImagesMap[typeId]) {
                                        this.productImages = $wire.typeImagesMap[typeId];
                                    }
                                });
                            }
                        }
                    }" x-init="// Initialize the images
                    initializeImages(activeTypeId);
                    
                    // Preload other types
                    preloadTypes();
                    
                    // Listen for image loaded events
                    $wire.on('imagesLoaded', ({ typeId }) => {
                        if (typeId === activeTypeId) {
                            productImages = $wire.typeImagesMap[typeId];
                        }
                    });"
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden"
                        wire:key="product-{{ $product->id }}">
                        <!-- Product Image - Reduced height slightly -->
                        <div class="relative h-40 bg-gray-50 dark:bg-gray-700">
                            <div class="w-full h-full" x-show="productImages && productImages.length > 0">
                                <!-- Main image -->
                                <template x-for="(image, index) in productImages" :key="index">
                                    <div x-show="currentImageIndex === index"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        class="absolute inset-0 w-full h-full">
                                        <img :src="'/storage/' + image.url" :alt="image.url || 'Product Image'"
                                            class="w-full h-full object-cover object-center" loading="lazy">
                                    </div>
                                </template>

                                <!-- Made dots smaller -->
                                <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-1"
                                    x-show="productImages.length > 1">
                                    <template x-for="(image, index) in productImages" :key="index">
                                        <button @click="currentImageIndex = index"
                                            :class="{
                                                'bg-white dark:bg-gray-500': currentImageIndex ===
                                                    index,
                                                'bg-white/50 dark:bg-gray-500/50': currentImageIndex !== index
                                            }"
                                            class="h-1 w-4 rounded-full transition-all duration-300"></button>
                                    </template>
                                </div>

                                <!-- Made navigation arrows a bit smaller -->
                                <div x-show="productImages.length > 1"
                                    class="absolute inset-0 flex items-center justify-between px-2">
                                    <button
                                        @click="currentImageIndex = (currentImageIndex - 1 + productImages.length) % productImages.length"
                                        class="p-1 rounded-full bg-black/20 dark:bg-gray-900/20 backdrop-blur-sm text-white hover:bg-black/30 dark:hover:bg-gray-900/30 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button @click="currentImageIndex = (currentImageIndex + 1) % productImages.length"
                                        class="p-1 rounded-full bg-black/20 dark:bg-gray-900/20 backdrop-blur-sm text-white hover:bg-black/30 dark:hover:bg-gray-900/30 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Enhanced empty state with loading indicator -->
                            <div x-show="!productImages || productImages.length === 0"
                                class="w-full h-full flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 text-gray-400 dark:text-gray-500 mb-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada foto produk</p>
                            </div>

                            <!-- Shop Closed Overlay -->
                            <div x-show="isShopClosed"
                                class="absolute top-2 right-2 px-2 py-0.5 bg-red-500 text-white text-sm font-bold rounded shadow-sm">
                                Toko Tutup
                            </div>
                        </div>

                        <!-- Product Info - Made padding smaller -->
                        <div class="p-3">
                            <!-- Product Name & Category - Made fonts smaller -->
                            <div class="mb-1.5 flex justify-between items-start">
                                <h2 class="text-lg max-md:text-xl font-bold text-gray-900 dark:text-gray-100 inline">
                                    {{ $product->name }}</h2>
                                {{-- <span
                                    class="text-sm font-medium px-1.5 py-0.5 inline-flex items-center bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 ring-1 ring-gray-700 dark:ring-gray-600 rounded-md transition-colors duration-200">
                                    {{ $product->category->name }}
                                </span> --}}
                            </div>

                            <!-- Description - Made smaller -->
                            <!-- Variant Selection with Description - More compact -->
                            <div class="space-y-2">
                                @foreach ($product->types as $index => $type)
                                    <div x-show="activeTypeIndex === {{ $index }}">
                                        <!-- Type Description -->
                                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2 mb-2">
                                            {{ $type->description }}
                                        </p>
                                    </div>
                                @endforeach

                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($product->types as $index => $type)
                                        <button wire:loading.attr="disabled"
                                            @click="changeType({{ $type->id }}, {{ $index }})"
                                            :class="{
                                                'bg-indigo-50 dark:bg-indigo-900 text-gray-700 dark:text-white ring-1 ring-indigo-500 dark:ring-indigo-400': activeTypeId ===
                                                    {{ $type->id }},
                                                'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300': activeTypeId !==
                                                    {{ $type->id }}
                                            }"
                                            class="px-2 py-1 rounded-lg text-sm font-medium transition-all duration-200">
                                            {{ $type->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price & Order Button - Gojek Style - More compact -->
                            @foreach ($product->types as $index => $type)
                                <div x-show="activeTypeIndex === {{ $index }}"
                                    class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 mb-1">Harga</p>
                                        @if($type->promo_price)
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm text-gray-400 line-through">
                                                    Rp {{ number_format($type->price, 0, ',', '.') }}
                                                </p>
                                                <p class="text-base font-bold text-indigo-600 dark:text-indigo-400">
                                                    Rp {{ number_format($type->promo_price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-base font-bold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($type->price, 0, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Modified Order Button - Changes based on shop status -->
                                    {{-- <template x-if="!isShopClosed && {{ $type->is_available ? 'true' : 'false' }}">
                                        <button
                                            class="flex-none bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600 dark:hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg font-medium text-sm transition-all duration-200 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="#fcfcfc" viewBox="0 0 256 256">
                                                <path d="M224,64l-12.16,66.86A16,16,0,0,1,196.1,144H70.55L56,64Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M230.14,58.87A8,8,0,0,0,224,56H62.68L56.6,22.57A8,8,0,0,0,48.73,16H24a8,8,0,0,0,0,16h18L67.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,160,204a28,28,0,1,0,28-28H91.17a8,8,0,0,1-7.87-6.57L80.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,230.14,58.87Z">
                                                </path>
                                            </svg>
                                            Pesan
                                        </button>
                                    </template>

                                    <template x-if="isShopClosed && {{ $type->is_available ? 'true' : 'false' }}">
                                        <span
                                            class="flex-none px-2 py-1.5 bg-amber-100 dark:bg-amber-200 text-amber-800 dark:text-amber-900 rounded-lg text-sm font-medium">
                                            Toko Tutup
                                        </span>
                                    </template>

                                    <template x-if="!{{ $type->is_available ? 'true' : 'false' }}">
                                        <span
                                            class="flex-none px-2 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg text-sm font-medium">
                                            Stok Habis
                                        </span>
                                    </template> --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
    @endif
</div>
</div>
