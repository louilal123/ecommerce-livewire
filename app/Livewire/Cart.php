<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Cart as CartModel;
use Livewire\Attributes\On;

class Cart extends Component
{
    public $cart;

    public function mount()
    {
        $this->cart = $this->getCart();

        if ($this->cart) {
            Session::put('cart_token', $this->cart->token);
            $this->cart->load('items.product');
        }
    }

    #[On('cart-updated')]
    public function refreshCart()
    {   $this->cart = $this->getCart()?->load('items.product');
    }

    public function getTotalQuantityProperty()
    {
        return $this->cart?->items->sum('quantity') ?? 0;
    }

    public function getTotalAmountProperty()
    {
        return $this->cart?->items->sum(fn ($item) => $item->product->price * $item->quantity) ?? 0;
    }

    public function getItemsProperty()
    {
        return $this->cart?->items ?? collect();
    }

     protected function getCart(): ?CartModel
{
    if (auth()->check()) {
        // Logged-in user
        return CartModel::firstOrCreate(
            ['user_id' => auth()->id()],
            ['token' => (string) Str::uuid(), 'last_active_at' => now()]
        );
    }

    // Guest user
    $token = Session::get('cart_token');

    if (!$token) {
        $token = (string) Str::uuid();
        Session::put('cart_token', $token);
    }

    return CartModel::firstOrCreate(
        ['token' => $token, 'user_id' => null],
        ['last_active_at' => now()]
    );
}



    public function removeItem($itemId)
    {
        if (!$this->cart) return;

        $item = $this->cart->items()->where('id', $itemId)->first();

        if ($item) {
            $item->delete();
            $this->dispatch('toast', message: 'Item Removed from cart!');
            $this->refreshCart(); 
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
