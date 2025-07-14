<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Cart as CartModel;
use App\Services\StripeService;

#[Layout('components.layouts.auth')]
class Cartlist extends Component
{
    use WithPagination;

    public $cart;
    public string $search = '';

    public function mount()
    {
        $this->cart = $this->getCart();
    }

    public function getItemsProperty()
    {
        return CartItem::with('product')
            ->where('cart_id', $this->cart->id)
            ->whereHas('product', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate(5);
    }

    public function getAllItemsProperty()
    {
        return CartItem::with('product')
            ->where('cart_id', $this->cart->id)
            ->get();
    }
  
    public function getSubtotalProperty()
    {
        return $this->allItems->sum(fn ($item) => $item->product->price * $item->quantity);
    }

    public function getDiscountProperty()
    {
        return 0;
    }

    public function getTotalProperty()
    {
        return $this->subtotal - $this->discount;
    }

    public function incrementQuantity($itemId)
    {
        CartItem::where('cart_id', $this->cart->id)
            ->where('id', $itemId)
            ->increment('quantity');
             $this->dispatch('toast', message: 'Quantity updated!');
    }

    public function decrementQuantity($itemId)
    {
        $item = CartItem::where('cart_id', $this->cart->id)
            ->where('id', $itemId)
            ->first();

        if ($item && $item->quantity > 1) {
            $item->decrement('quantity');
            $this->dispatch('toast', message: 'Quantity updated!');
        } elseif ($item) {
            $item->delete();
             $this->dispatch('toast', message: 'Item removed from cart!');
        }
    }

    public function removeItem($itemId)
    {
        CartItem::where('cart_id', $this->cart->id)
            ->where('id', $itemId)
            ->delete();
           
              $this->dispatch('toast', message: 'Item Removed from cart!');
            $this->dispatch('cart-updated');
    }
    // this page is served only for authenticated users so where getting the data by user id always 
    protected function getCart(): ?CartModel
    {
        return auth()->check()
            ? CartModel::where('user_id', auth()->id())->first()
            : null;
    }

    public function proceedToCheckout(StripeService $stripe)
    {
        $lineItems = $this->allItems->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'php',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->product->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        $checkoutUrl = $stripe->createCheckoutSession($lineItems);

        return redirect()->away($checkoutUrl);
    }

    public function render()
    {
        return view('livewire.cartlist');
    }
}
