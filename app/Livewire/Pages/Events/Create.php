<?php

namespace App\Livewire\Pages\Events;

use App\Models\Event;
use Livewire\Component;

class Create extends Component
{
    public Service $form;

    public function mount(Event $event)
    {
        $this->form->setEvent($event);
    }

    public function store()
    {
        $this->form->store();
        session()->flash('message', 'Event created successfully.');
        return redirect()->route('admin.events.index');
    }

    public function render()
    {
        return view('livewire.pages.events.create');
    }
}
