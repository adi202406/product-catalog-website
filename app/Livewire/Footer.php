<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ShopInfo;

class Footer extends Component
{
    public $shopInfo;
    public $year;
    
    public function mount()
    {
        // Fetch shop information including social media
        $this->shopInfo = ShopInfo::with('socialMedia')
            ->first();
        
        // Current year for copyright
        $this->year = date('Y');
    }

    public function render()
    {
        return view('livewire.footer');
    }
}