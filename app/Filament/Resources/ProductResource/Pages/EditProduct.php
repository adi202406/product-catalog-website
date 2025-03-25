<?php
namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    // Store the original types data for comparison
    protected $originalTypes = [];

    // Override the mount method to capture the original types data
    public function mount($record): void
    {
        parent::mount($record);

        // Store the original types with their images
        $this->originalTypes = $this->record->types->map(function ($type) {
            return [
                'id'     => $type->id,
                'images' => $type->images->pluck('url')->toArray(),
            ];
        })->toArray();
    }

    // Add this method to clear the cache after saving
    protected function afterSave(): void
    {
        // Get the current types with their images
        $currentTypes = $this->record->refresh()->types->map(function ($type) {
            return [
                'id'     => $type->id,
                'images' => $type->images->pluck('url')->toArray(),
            ];
        })->toArray();

        // Collect all type IDs that need cache invalidation (either new or modified)
        $typeIdsToInvalidate = [];

        // Check for new or modified types
        foreach ($currentTypes as $currentType) {
            $typeId                = $currentType['id'];
            $typeIdsToInvalidate[] = $typeId;
        }

        // Check for deleted types
        foreach ($this->originalTypes as $originalType) {
            $originalTypeId = $originalType['id'];
            $stillExists    = false;

            foreach ($currentTypes as $currentType) {
                if ($currentType['id'] === $originalTypeId) {
                    $stillExists = true;
                    break;
                }
            }

            if (! $stillExists) {
                $typeIdsToInvalidate[] = $originalTypeId;
            }
        }

        // Invalidate cache for all affected type IDs
        foreach (array_unique($typeIdsToInvalidate) as $typeId) {
            $cacheKey = "type_images_{$typeId}";
            Cache::forget($cacheKey);

            // Dispatch the Livewire event
            $this->dispatch('imageUpdated', typeId: $typeId);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
