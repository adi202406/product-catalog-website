<!-- resources/views/livewire/image-carousel.blade.php -->
<div class="relative h-64 bg-gray-100 overflow-hidden">
    <!-- Loading indicator -->
    @if($isLoading)
        <div class="absolute inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center z-10">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    @endif
    
    <div class="w-full h-full">
        @if(count($images) > 0)
            @foreach($images as $index => $image)
                @if($currentIndex === $index)
                    <div class="absolute inset-0 w-full h-full transition-opacity duration-300 ease-in-out {{ $currentIndex === $index ? 'opacity-100' : 'opacity-0' }}">
                        <img 
                            src="{{ '/storage/' . $image['url'] }}" 
                            alt="{{ $image['url'] ?? 'Product Image' }}" 
                            class="w-full h-full object-cover object-center"
                            loading="lazy"
                        >
                    </div>
                @endif
            @endforeach
            
            <!-- Image navigation dots -->
            @if(count($images) > 1)
                <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2">
                    @foreach($images as $index => $image)
                        <button
                            wire:click="setImage({{ $index }})"
                            class="h-2 w-2 rounded-full transition-all duration-300 {{ $currentIndex === $index ? 'bg-blue-600' : 'bg-gray-400' }}"
                        ></button>
                    @endforeach
                </div>
                
                <!-- Navigation arrows for multiple images -->
                <button
                    wire:click="prevImage"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 rounded-full p-1 hover:bg-opacity-100 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    wire:click="nextImage"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 rounded-full p-1 hover:bg-opacity-100 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @endif
        @else
            <!-- Empty state -->
            <div class="w-full h-full flex items-center justify-center">
                <p class="text-gray-500">Tidak ada gambar untuk tipe produk ini</p>
            </div>
        @endif
    </div>
</div>