<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

#[Layout('components.layouts.auth')]
class Success extends Component
{
    public function mount()
    {
        $cart = Cart::where('token', session('cart_token'))->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return; 
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'payment_id' => 'placeholder', 
            'status' => 'paid',
            'total' => $cart->items->sum(fn ($item) => $item->product->price * $item->quantity),
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->delete(); 
    }

    public function render()
    {
        return view('livewire.success');
    }
}
