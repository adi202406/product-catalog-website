<div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
    <!-- Image Carousel -->
    <div class="relative h-64 bg-gray-100 overflow-hidden">
        <!-- Loading indicator -->
        <div wire:loading class="absolute inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center z-10">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        
        <div class="w-full h-full" x-show="$wire.typeImages.length > 0">
            <!-- Main image -->
            <template x-for="(image, index) in $wire.typeImages" :key="index">
                <div 
                    x-show="currentImageIndex === index"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="absolute inset-0 w-full h-full"
                >
                    <img 
                        :src="'/storage/' + image.url" 
                        :alt="image.url || 'Product Image'" 
                        class="w-full h-full object-cover object-center"
                        loading="lazy"
                    >
                </div>
            </template>
            
            <!-- Image navigation dots -->
            <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2" x-show="$wire.typeImages.length > 1">
                <template x-for="(image, index) in $wire.typeImages" :key="index">
                    <button
                        @click="currentImageIndex = index"
                        :class="{'bg-blue-600': currentImageIndex === index, 'bg-gray-400': currentImageIndex !== index}"
                        class="h-2 w-2 rounded-full transition-all duration-300"
                    ></button>
                </template>
            </div>
            
            <!-- Navigation arrows for multiple images -->
            <div x-show="$wire.typeImages.length > 1">
                <button
                    @click="currentImageIndex = (currentImageIndex - 1 + $wire.typeImages.length) % $wire.typeImages.length"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 rounded-full p-1 hover:bg-opacity-100 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    @click="currentImageIndex = (currentImageIndex + 1) % $wire.typeImages.length"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 rounded-full p-1 hover:bg-opacity-100 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Empty state -->
        <div x-show="$wire.typeImages.length === 0" class="w-full h-full flex items-center justify-center">
            <p class="text-gray-500">Tidak ada gambar untuk tipe produk ini</p>
        </div>
    </div>

    <div class="p-6">
        <div class="flex justify-between items-start">
            <h2 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $product->category->name }}</span>
        </div>
        
        <p class="text-gray-600 mt-2 text-sm line-clamp-2">{{ $product->description }}</p>
        
        <div class="mt-4">
            <h3 class="text-md font-medium text-gray-700 mb-2">Tipe Produk</h3>
            
            <!-- Type selector buttons -->
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($product->types as $index => $type)
                    <button 
                        @click="changeType({{ $type->id }}, {{ $index }})"
                        :class="{'bg-blue-100 text-blue-800 ring-2 ring-blue-500': activeTypeId === {{ $type->id }}, 'bg-gray-50 hover:bg-gray-100 text-gray-700': activeTypeId !== {{ $type->id }}}"
                        class="px-3 py-1 rounded-md text-sm font-medium transition-all duration-300"
                    >
                        {{ $type->name }}
                    </button>
                @endforeach
            </div>
            
            <!-- Display active type details -->
            @foreach($product->types as $index => $type)
                <div 
                    x-show="activeTypeIndex === {{ $index }}"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="bg-gray-50 rounded-md p-3 mb-2"
                >
                    <div class="flex justify-between items-center">
                        <span class="font-medium">{{ $type->name }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($type->price, 0, ',', '.') }}</span>
                            @if($type->is_available)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Stok Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                Tambah ke Keranjang
            </button>
        </div>
    </div>
</div>