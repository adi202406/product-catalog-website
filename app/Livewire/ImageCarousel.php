<?php

namespace App\Livewire;

use App\Models\Image;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ImageCarousel extends Component
{
    public $typeId;
    public $images = [];
    public $currentIndex = 0;
    public $isLoading = false;
    
    // Event listeners
    protected $listeners = ['typeChanged'];
    
    public function mount($initialTypeId)
    {
        $this->typeId = $initialTypeId;
        $this->loadImages();
    }
    
    public function typeChanged($typeId)
    {
        $this->typeId = $typeId;
        $this->currentIndex = 0;
        $this->isLoading = true;
        $this->loadImages();
    }
    
    public function loadImages()
    {
        if (!$this->typeId) {
            $this->images = [];
            $this->isLoading = false;
            return;
        }
        
        // Use cache with shorter expiration for better freshness
        $cacheKey = "type_images_{$this->typeId}";
        
        if (Cache::has($cacheKey)) {
            $this->images = Cache::get($cacheKey);
            $this->isLoading = false;
        } else {
            // Optimize query with select to reduce data transfer
            $this->images = Image::where('type_id', $this->typeId)
                ->select(['id', 'url', 'type_id'])
                ->get()
                ->toArray();
                
            Cache::put($cacheKey, $this->images, now()->addMinutes(15));
            $this->isLoading = false;
        }
    }
    
    public function nextImage()
    {
        if (count($this->images) > 0) {
            $this->currentIndex = ($this->currentIndex + 1) % count($this->images);
        }
    }
    
    public function prevImage()
    {
        if (count($this->images) > 0) {
            $this->currentIndex = ($this->currentIndex - 1 + count($this->images)) % count($this->images);
        }
    }
    
    public function setImage($index)
    {
        if ($index >= 0 && $index < count($this->images)) {
            $this->currentIndex = $index;
        }
    }
    
    public function render()
    {
        return view('livewire.image-carousel');
    }
}