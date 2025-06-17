<x-filament-panels::page>
    {{$this->table}}
    {{-- @if ($this->createResult)
    <form wire:submit.prevent = "next">
        <x-filament::button type="submit" class="w-auto px-4 mt-3">
            Check marks
        </x-filament::button> 
    </form>
    {{$this->table}}
    @endif
    @if ($this->createNext)
    <x-filament::button wire:click="back" class="w-auto px-4 mt-3">
        back
    </x-filament::button> 
    <livewire:result-page />
        
    @endif
    @if ($this->makeResult)
     <x-filament::button wire:click="back" class="w-auto px-4 mt-3">
        back
    </x-filament::button> 
    @endif --}}
    
</x-filament-panels::page>
