<?php

namespace App\Livewire\Component;

use Livewire\Component;

class ProductLoadingPlaceholder extends Component
{
    // Number of placeholder items to show
    public $count = 8;
    
    // Control loading state
    public $loading = true;

    public function mount($count = 8)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('livewire.component.product-loading-placeholder', [
            'count' => $this->count,
            'loading' => $this->loading
        ]);
    }
}