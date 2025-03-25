<?php

namespace App\Livewire;

use Livewire\Component;

class TypeSelector extends Component
{
    public $product;
    public $activeTypeId;
    
    public function selectType($typeId)
    {
        $this->dispatch('typeChanged', typeId: $typeId);
    }
    
    public function render()
    {
        return view('livewire.type-selector');
    }
}