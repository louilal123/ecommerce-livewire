<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'productCount' => Product::count(),
            'orderCount' => Order::where('status', 'paid')->count(),
            'salesTotal' => Order::where('status', 'paid')->sum('total'),
            'userCount' => User::where('role', 'user')->count(),
        ]);
    }
}

