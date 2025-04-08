<?php

namespace App\Livewire\Pages\Guests;

use App\Models\Guest;
use Livewire\Component;

class Table extends Component
{
    public function render()
    {
        $guests = Guest::all();
        return view('livewire.pages.guests.table', compact('guests'));
    }
}
