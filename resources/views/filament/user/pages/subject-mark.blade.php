<x-filament-panels::page>
    @if ($this->createMark)
    <form wire:submit.prevent="next">
        {{ $this->form }}
        <x-filament::button type="submit" class="w-auto px-4 mt-3">
            Submit
        </x-filament::button>    
    </form>
    @endif
    @if ($this->createNext)
    <x-filament::button wire:click="back" class="w-auto px-4 mt-3">
        back
    </x-filament::button>  
    <livewire:mark-page />
   
    </form>
    @endif
</x-filament-panels::page>

