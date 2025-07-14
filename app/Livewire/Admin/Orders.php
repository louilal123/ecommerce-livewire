<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Order;

#[Layout('components.layouts.admin')]
class Orders extends Component
{
    public function render()
    {
        $orders = Order::with(['user', 'items.product']) 
                ->orderByDesc('created_at')
                ->paginate(8);
                
        return view('livewire.admin.orders', [
            'orders' => $orders
        ]);
    }
}
