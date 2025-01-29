<div>
   <form wire:submit.prevent="submit">
      {{$this->form}}
    <x-filament::button type="submit" class="w-auto px-4 mt-3">
      Enter  </x-filament::button> 
   </form>
   {{$this->table}}
</div>