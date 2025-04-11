<div class="grid grow focus-within:relative">
    <input type="text" wire:model.live.debounce.250ms="search" placeholder="Recherche"
        class="col-start-1 row-start-1 block w-full md:w-72 rounded-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 dark:bg-gray-800 dark:text-white outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-600 placeholder:text-gray-400 dark:placeholder-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:pl-9 sm:text-sm/6">
    <x-heroicon-o-magnifying-glass
        class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400 dark:text-gray-500 sm:size-4" />
</div>
