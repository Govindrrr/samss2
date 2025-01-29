<x-filament-panels::page>
    @if ($this->createResult)
    <form wire:submit.prevent = "next">
        {{$this->form}}
        <x-filament::button type="submit" class="w-auto px-4 mt-3">
            Check marks
        </x-filament::button> 
        <x-filament::button wire:click="result" class="w-18 px-4">
            Go For Result
        </x-filament::button> 
    </form>
    @endif
    @if ($this->createNext)
    <x-filament::button wire:click="back" class="w-auto px-4 mt-3">
        back
    </x-filament::button> 
        
        {{$this->table}}
    @endif
    @if ($this->makeResult)
     <x-filament::button wire:click="back" class="w-auto px-4 mt-3">
        back
    </x-filament::button> 
    <livewire:result-page />
    @endif
    
</x-filament-panels::page>
