<?php

namespace App\Livewire\Pages\Events;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Service extends Form
{
    public ?Event $events;

    #[Validate]
    public $name = '';

    #[Validate]
    public $description = '';

    #[Validate]
    public $location = '';

    #[Validate]
    public $start_date = '';

    #[Validate]
    public $end_date = '';

    public $organizer_id;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'start_date' => 'date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function setEvent(Event $event)
    {
        $this->events = $event;
        $this->name = $event->name;
        $this->description = $event->description;
        $this->location = $event->location;
        $this->start_date = $event->start_date;
        $this->end_date = $event->end_date;
        $this->organizer_id = $event->organizer_id;
    }

    public function store()
    {
        $this->validate();
        $this->organizer_id = Auth::id();
        Event::create($this->all());
    }

    public function update()
    {
        $this->validate();
        $this->events->organizer_id = Auth::id();
        $this->events->update($this->all());
    }
}
