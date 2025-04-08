<?php

namespace App\Livewire\Pages\Events;

use App\Models\Event;
use Livewire\Component;

class Edit extends Component
{
    public Service $form;

    public function mount(Event $event)
    {
        $this->form->setEvent($event);
    }

    public function update()
    {
        $this->form->update();
        session()->flash('message', 'Événement mis à jour avec succès.');
        return redirect()->route('admin.events.index');
    }

    public function render()
    {
        return view('livewire.pages.events.edit');
    }
}
