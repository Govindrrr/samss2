<x-filament-panels::page>
    <form>

        {{ $this->form }}
    </form>
    <div>
        <x-filament::button wire:click="Submit" class="w-36 px-4 mt-4">
            Check marks
        </x-filament::button>
        
    </div>

</x-filament-panels::page>
