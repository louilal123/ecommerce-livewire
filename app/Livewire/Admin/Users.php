<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;

#[Layout('components.layouts.admin')]
class Users extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
          $users = User::query()
            ->when($this->search, fn ($query) =>
                $query->where('name', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(8);

        return view('livewire.admin.users', compact('users'));
    }
}
