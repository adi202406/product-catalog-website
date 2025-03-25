<?php

namespace App\Livewire;

use Livewire\Component;

class ProductSearch extends Component
{
    public $search = '';
    
    // Debounce input untuk mencegah terlalu banyak query
    protected $updatesQueryString = ['search'];
    
    public function mount()
    {
        // Optionally restore search from query string
        $this->search = request()->query('search', '');
    }
    
    public function updatedSearch()
    {
        // Dispatch event setiap kali input pencarian berubah
        // dengan delay 300ms untuk mengurangi terlalu banyak request
        $this->dispatch('searchUpdated', search: $this->search);
    }
    
    public function clearSearch()
    {
        $this->search = '';
        $this->dispatch('searchUpdated', search: '');
    }
    
    public function render()
    {
        return view('livewire.product-search');
    }
}