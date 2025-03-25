<div x-ref="imageComponent">
    {{-- Tampilan gambar berdasarkan type_id --}}
    @if($images->count() > 0)
        <div class="w-full h-full">
            <div class="carousel relative">
                @foreach($images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ 'storage/'. $image->url }}" alt="{{ $image->alt_text ?? 'Product Image' }}" 
                                class="w-full h-60 object-cover object-center">
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="flex items-center justify-center h-full w-full bg-gray-100">
            <p class="text-gray-500">Tidak ada gambar untuk tipe produk ini</p>
        </div>
    @endif
</div>