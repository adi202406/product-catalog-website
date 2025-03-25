<?php

namespace App\Livewire;

use App\Models\ShopInfo;
use Livewire\Component;

class HomePage extends Component
{
    public $shopName;
    public $shopStatus;
    public $shopMessage;
    public $shopUrlLogo;

    public function mount()
    {
        $shopInfo = ShopInfo::with('socialMedia')->first();

        if (!$shopInfo) {
            abort(404, 'Shop Info not found');
        }

        $this->shopName = $shopInfo->name;
        $this->shopStatus = $shopInfo->is_open;
        $this->shopMessage = $shopInfo->message;
        $this->shopUrlLogo = $shopInfo->url_logo ? "/storage/" . $shopInfo->url_logo : null;
    }
    
    public function render()
    {
        return view('livewire.home-page');
    }
}
