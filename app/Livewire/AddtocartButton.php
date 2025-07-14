<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AddToCartButton extends Component
{
    public $productId;

    public function addToCart()
    {
        $product = Product::findOrFail($this->productId);
        $cart = $this->createCart();

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
            $this->dispatch('toast', message: 'Item added to cart successfully!');
            $this->dispatch('cart-updated');
        }

        $cart->update(['last_active_at' => now()]);

        $this->dispatch('toast', message: 'Added to cart!');
        $this->dispatch('cart-updated');
    }

    protected function createCart(): CartModel
    {
        $token = Session::get('cart_token');

        if (!$token) {
            $token = (string) Str::uuid();
            Session::put('cart_token', $token);
        }

        $cart = CartModel::firstOrCreate(
            ['token' => $token],
            ['last_active_at' => now()]
        );

        $this->dispatch('cart-updated');
        return $cart;
    }

    public function render()
    {
        return view('livewire.addtocart-button');
    }
}
