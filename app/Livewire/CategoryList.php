<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;

class CategoryList extends Component
{
    public $categories;
    public $selectedCategoryId = null;
    
    public function mount()
    {
        $this->loadCategories();
        
        $this->selectedCategoryId = null;
    }
    
    #[On('refreshCategories')]
    public function loadCategories()
    {
        // Load categories with counts of associated products
        $this->categories = Category::withCount('products')
            ->orderBy('name')
            ->get();
    }

    public function showAllProducts()
    {
        $this->selectedCategoryId = null;
        
        // Dispatch event to ProductCatalog component
        $this->dispatch('categorySelected', categoryId: null);
    }
    
    public function selectCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
        
        // Dispatch event to ProductCatalog component
        $this->dispatch('categorySelected', categoryId: $categoryId);
    }
    
    public function placeholder()
    {
        return view('livewire.component.category-loading-placeholder');
    }
    
    public function render()
    {
        return view('livewire.category-list');
    }
}