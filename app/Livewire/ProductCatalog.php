<?php
namespace App\Livewire;
use App\Models\Image;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
class ProductCatalog extends Component
{
    public $products;
    public $typeImagesMap = []; // Changed from single array to a map of type ID to images
    public $loadedTypeIds = [];
    public $selectedCategoryId = null;
    public $searchQuery = '';
    public $shopStatus;
    
    protected $listeners = [
        'categorySelected' => 'handleCategorySelected',
        'searchUpdated' => 'handleSearchUpdated',
        'imageUpdated' => 'handleImageUpdated' // Add new listener for image updates
    ];
    
    public function mount()
    {
        // Load all products initially
        $this->loadProducts();
        
        // Preload images for all products immediately
        $this->preloadAllProductImages();
    }
    
    public function handleCategorySelected($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
        $this->loadProducts();
        
        // Reset type images when changing categories
        $this->typeImagesMap = [];
        $this->loadedTypeIds = [];
        
        // Preload images for all products in the new category
        $this->preloadAllProductImages();
    }
    
    public function handleSearchUpdated($search)
    {
        $this->searchQuery = $search;
        $this->loadProducts();
        
        // Reset type images when searching
        $this->typeImagesMap = [];
        $this->loadedTypeIds = [];
        
        // Preload images for all products in search results
        $this->preloadAllProductImages();
    }
    
    // Add new handler for image updates
    public function handleImageUpdated($typeId)
    {
        // Clear the cache for this type
        $this->clearTypeImageCache($typeId);
        
        // Reload images for this type
        $this->loadTypeImages($typeId, true);
    }
    
    // New method to clear type image cache
    protected function clearTypeImageCache($typeId)
    {
        $cacheKey = "type_images_{$typeId}";
        Cache::forget($cacheKey);
        
        // Also remove from loaded arrays
        if (isset($this->typeImagesMap[$typeId])) {
            unset($this->typeImagesMap[$typeId]);
        }
        
        $index = array_search($typeId, $this->loadedTypeIds);
        if ($index !== false) {
            unset($this->loadedTypeIds[$index]);
            $this->loadedTypeIds = array_values($this->loadedTypeIds); // Reindex array
        }
    }
    
    protected function preloadAllProductImages()
    {
        // Preload images for all products
        foreach ($this->products as $product) {
            if ($product->types->isNotEmpty()) {
                foreach ($product->types as $type) {
                    $this->preloadTypeImages($type->id);
                }
            }
        }
    }
    
    protected function loadProducts()
    {
        // Start with base query
        $query = Product::with(['types']);
        
        // Filter by category if selected
        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }
        
        // Apply search filter if provided
        if (!empty($this->searchQuery)) {
            $searchTerm = '%' . $this->searchQuery . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhereHas('category', function ($catQuery) use ($searchTerm) {
                      $catQuery->where('name', 'like', $searchTerm);
                  })
                  ->orWhereHas('types', function ($typeQuery) use ($searchTerm) {
                      $typeQuery->where('name', 'like', $searchTerm);
                      $typeQuery->where('description', 'like', $searchTerm);
                  });
            });
        }
        
        $this->products = $query->get();

    }

    public function placeholder(array $params = [])
    {
        return view('livewire.component.product-loading-placeholder', [
            'count' => $params['count'] ?? 8
        ]);
    }
    
    public function loadTypeImages($typeId, $forceRefresh = false)
    {
        if (!$typeId) {
            return;
        }
        
        // Use cache to store and retrieve images
        $cacheKey = "type_images_{$typeId}";
        
        // Skip cache if force refresh is requested
        if (!$forceRefresh && Cache::has($cacheKey)) {
            $this->typeImagesMap[$typeId] = Cache::get($cacheKey);
        } else {
            $images = Image::where('type_id', $typeId)
                ->select(['id', 'url', 'type_id'])
                ->get()
                ->toArray();
                
            Cache::put($cacheKey, $images, now()->addMinutes(30));
            $this->typeImagesMap[$typeId] = $images;
        }
        
        if (!in_array($typeId, $this->loadedTypeIds)) {
            $this->loadedTypeIds[] = $typeId;
        }
        
        $this->dispatch('imagesLoaded', typeId: $typeId);
    }
    
    public function preloadTypeImages($typeId, $forceRefresh = false)
    {
        // Skip if already loaded or missing type ID
        if (!$typeId || (!$forceRefresh && in_array($typeId, $this->loadedTypeIds))) {
            return;
        }
        
        $cacheKey = "type_images_{$typeId}";
        
        // Skip cache if force refresh is requested
        if ($forceRefresh) {
            Cache::forget($cacheKey);
        }
        
        // Only fetch and cache if not already cached
        if (!Cache::has($cacheKey)) {
            $images = Image::where('type_id', $typeId)
                ->select(['id', 'url', 'type_id'])
                ->get()
                ->toArray();
                
            Cache::put($cacheKey, $images, now()->addMinutes(30));
            $this->typeImagesMap[$typeId] = $images;
        } else {
            // Store in the map if it's a cache hit
            $this->typeImagesMap[$typeId] = Cache::get($cacheKey);
        }
        
        if (!in_array($typeId, $this->loadedTypeIds)) {
            $this->loadedTypeIds[] = $typeId;
        }
    }
    
    public function render()
    {
        return view('livewire.product-catalog');
    }
}