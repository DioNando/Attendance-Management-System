<?php

namespace App\Livewire\Pages\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Table extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $sortField = 'last_name';
    public $sortDirection = 'asc';

    protected $listeners = [
        'searchUpdated' => 'updateSearch',
        'roleUpdated' => 'updateRole',
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updateSearch($search)
    {
        // This method will be called when the search input is updated
        $this->search = $search;
        $this->resetPage(); // Reset to first page when searching
    }

    public function updateRole($role)
    {
        // This method will be called when the role is updated
        $this->role = $role;
        $this->resetPage(); // Reset to first page when filtering by role
    }

    public function deleteUser($userId)
    {
        // Vérifier si l'utilisateur n'est pas l'utilisateur actuel
        if (Auth::id() !== (int)$userId) {
            User::destroy($userId);
            session()->flash('message', 'Utilisateur supprimé avec succès.');
        } else {
            session()->flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->role, function ($query) {
                $query->where('role', $this->role);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        return view('livewire.pages.user.table', compact('users'));
    }
}
