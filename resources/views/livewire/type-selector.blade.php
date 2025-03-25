<div class="mt-4">
    <h3 class="text-md font-medium text-gray-700 mb-2">Tipe Produk</h3>
    
    <!-- Type selector buttons -->
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach($product->types as $type)
            <button 
                wire:click="selectType({{ $type->id }})"
                class="px-3 py-1 rounded-md text-sm font-medium transition-all duration-300 {{ $activeTypeId === $type->id ? 'bg-blue-100 text-blue-800 ring-2 ring-blue-500' : 'bg-gray-50 hover:bg-gray-100 text-gray-700' }}"
            >
                {{ $type->name }}
            </button>
        @endforeach
        @php
            dump($activeTypeId)
        @endphp
    </div>
    
    <!-- Display active type details -->
    @foreach($product->types as $type)
        @if($activeTypeId === $type->id)
            <div class="bg-gray-50 rounded-md p-3 mb-2">
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $type->name }}</span>
                    @php
                        dump($type->name)
                    @endphp
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
        @endif
    @endforeach
</div>