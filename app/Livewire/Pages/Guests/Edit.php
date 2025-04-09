<?php

namespace App\Livewire\Pages\Guests;

use App\Models\Event;
use App\Models\Guest;
use Livewire\Component;

class Edit extends Component
{
    public Service $form;
    public $event;

    public function mount(Guest $guest)
    {
        $event_id = request()->query('event_id', 1);
        $this->form->setGuest($guest);
        $this->event = Event::findOrFail($event_id);
        $this->form->event_id = $event_id;
    }
    
    public function update()
    {
        $this->form->update();
        session()->flash('message', 'Invité mis à jour avec succès.');
        return redirect()->route('admin.events.show', $this->event);
    }

    public function render()
    {
        return view('livewire.pages.guests.edit');
    }
}
