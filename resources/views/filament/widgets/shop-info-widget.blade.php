<x-filament-widgets::widget>
    <x-filament::section>
        {{ $this->form }}
        
        <div class="mt-4 text-right">
            <x-filament::button wire:click="submit">
                Simpan
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>