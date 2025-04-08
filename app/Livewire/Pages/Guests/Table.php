<?php

namespace App\Livewire\Pages\Guests;

use App\Models\Guest;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $event;
    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'guestImported' => 'updatePage',
        'searchUpdated' => 'updateSearch',
    ];

    public function updatePage()
    {
        // This method will be called when guests are imported
        $this->dispatch('$refresh'); // Force a refresh of the component
    }

    public function updateSearch($search)
    {
        // This method will be called when the search input is updated
        $this->search = $search;
        $this->resetPage(); // Reset to first page when searching
    }

    public function render()
    {
        $guests = Guest::where('event_id', $this->event->id)
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy('first_name')
            // ->paginate($this->perPage);
            ->get();

        return view('livewire.pages.guests.table', compact('guests'));
    }
}
