<?php

namespace App\Livewire\Pages\Events;

use App\Models\Event;
use Livewire\Component;

class Table extends Component
{
    public function render()
    {
        $events = Event::all();
        return view('livewire.pages.events.table', compact('events'));
    }
}
