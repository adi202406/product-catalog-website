<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ShopInfo;

class Logo extends Component
{
    public $name;
    public $url_logo;

    public function mount()
    {
        $shopInfo = ShopInfo::select('name', 'url_logo')->first();
        $this->name = $shopInfo->name ?? 'Shop Name';
        $this->url_logo = $shopInfo->url_logo;
    }

    public function render()
    {
        return view('livewire.logo');
    }
}