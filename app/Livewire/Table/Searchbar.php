<?php

namespace App\Livewire\Table;

use Livewire\Component;

class Searchbar extends Component
{
    public $search = '';

    public function mount()
    {
        $this->search = request()->query('search', '');
    }

    public function updatedSearch()
    {
        $this->dispatch('searchUpdated', strtolower($this->search));
    }

    public function render()
    {
        return view('livewire.table.searchbar');
    }
}
