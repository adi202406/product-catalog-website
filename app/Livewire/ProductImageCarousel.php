<?php
namespace App\Livewire;

use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ProductImageCarousel extends Component
{
    public $typeId;
    public $images = [];
    public $currentImageIndex = 0;
    public $isLoading = true;

    protected $listeners = ['reloadImages' => 'loadImages'];

    public function mount($typeId)
    {
        $this->typeId = $typeId;
        $this->loadImages();
    }

    public function updatedTypeId()
    {
        // Saat tipe berubah, reset state dan muat ulang gambar
        $this->currentImageIndex = 0;
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

        $cacheKey = "type_images_{$this->typeId}";

        if (Cache::has($cacheKey)) {
            $this->images = Cache::get($cacheKey);
            $this->isLoading = false;
        } else {
            $this->images = Image::where('type_id', $this->typeId)
                ->select(['id', 'url', 'type_id'])
                ->get()
                ->toArray();

            Cache::put($cacheKey, $this->images, now()->addMinutes(30));
            $this->isLoading = false;
        }
    }

    public function nextImage()
    {
        if (count($this->images) > 0) {
            $this->currentImageIndex = ($this->currentImageIndex + 1) % count($this->images);
        }
    }

    public function previousImage()
    {
        if (count($this->images) > 0) {
            $this->currentImageIndex = ($this->currentImageIndex - 1 + count($this->images)) % count($this->images);
        }
    }

    public function render()
    {
        return view('livewire.product-image-carousel');
    }
}
