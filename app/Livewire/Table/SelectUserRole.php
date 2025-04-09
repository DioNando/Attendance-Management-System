<?php

namespace App\Livewire\Table;

use Livewire\Component;

class SelectUserRole extends Component
{
    public $role;

    public function mount($role = null)
    {
        $this->role = $role;
    }

    public function updatedRole()
    {
        $this->dispatch('roleUpdated', $this->role);
    }

    public function render()
    {
        return view('livewire.table.select-user-role');
    }
}
