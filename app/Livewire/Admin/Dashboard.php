<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public string $layout;

    public function mount(): void
    {
        $user = Auth::user();

        $this->layout = match (true) {
            !$user => 'layouts.app.header',
            $user->role === UserRole::Admin => 'layouts.app.sidebar',
            default => 'layouts.app.header',
        };
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'layout' => $this->layout
        ]);
    }
}

