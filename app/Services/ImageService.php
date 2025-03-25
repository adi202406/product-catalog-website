<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Cache;

class ImageService
{
    private $loadedTypeIds = [];
    private $cacheDuration = 30; // minutes
    
    public function getTypeImages($typeId)
    {
        if (!$typeId) {
            return [];
        }
        
        $cacheKey = "type_images_{$typeId}";
        
        // Return cached images if available
        if (Cache::has($cacheKey)) {
            $this->loadedTypeIds[] = $typeId;
            return Cache::get($cacheKey);
        }
        
        // Otherwise fetch from database
        $images = Image::where('type_id', $typeId)
            ->select(['id', 'url', 'type_id'])
            ->get()
            ->toArray();
            
        // Cache the results
        Cache::put($cacheKey, $images, now()->addMinutes($this->cacheDuration));
        
        $this->loadedTypeIds[] = $typeId;
        return $images;
    }
    
    public function preloadTypeImages($typeId)
    {
        // Skip if already loaded or invalid type ID
        if (!$typeId || in_array($typeId, $this->loadedTypeIds)) {
            return;
        }
        
        // Just call getTypeImages which handles caching
        $this->getTypeImages($typeId);
    }
    
    public function preloadProductTypesImages($product)
    {
        if ($product && $product->types) {
            foreach ($product->types as $type) {
                $this->preloadTypeImages($type->id);
            }
        }
    }
}