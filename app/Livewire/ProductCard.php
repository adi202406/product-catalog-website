<?php
namespace App\Livewire;

use App\Models\Image;
use App\Models\Type;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ProductCard extends Component
{
    public $product;
    public $activeTypeId;
    public $activeTypeIndex = 0;
    
    // Event listeners
    protected $listeners = ['typeChanged'];

    public function mount($product)
    {
        $this->product = $product;
        
        // Set initial active type
        if ($this->product->types->isNotEmpty()) {
            $this->activeTypeId = $this->product->types->first()->id;
        }
    }
    
    public function changeType($typeId, $index)
    {
        $this->activeTypeId = $typeId;
        $this->activeTypeIndex = $index;
        
        // Emit event to inform image carousel
        $this->dispatch('typeChanged', $typeId);
    }

    public function render()
    {
        return view('livewire.product-card');
    }
}
