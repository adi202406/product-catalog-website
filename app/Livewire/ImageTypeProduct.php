<?php

namespace App\Livewire;

use App\Models\Image;
use Livewire\Component;

class ImageTypeProduct extends Component
{
    public $typeId;
    public $images = [];
    
    // Menggunakan wire:model untuk binding typeId
    public function mount($typeId = null)
    {
        $this->typeId = $typeId;
        $this->loadImages();
    }
    
    // Method untuk memuat gambar berdasarkan type_id
    public function loadImages()
    {
        if ($this->typeId) {
            $this->images = Image::where('type_id', $this->typeId)->get();
        } else {
            $this->images = collect([]);
        }
    }
    
    // Method untuk memperbarui gambar ketika typeId berubah
    public function updatedTypeId()
    {
        $this->loadImages();
    }
    
    public function render()
    {
        return view('livewire.image-type-product');
    }
}