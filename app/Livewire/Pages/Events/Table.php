<?php

namespace App\Livewire\Pages\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'searchUpdated' => 'updateSearch',
    ];

    public function updateSearch($search)
    {
        // This method will be called when the search input is updated
        $this->search = $search;
        $this->resetPage(); // Reset to first page when searching
    }

    public function render()
    {
        $events = Event::where(function ($query) {
                if ($this->search) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                }
            })
            ->withCount(['guests'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.pages.events.table', compact('events'));
    }
}
