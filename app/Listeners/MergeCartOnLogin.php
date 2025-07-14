<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class MergeCartOnLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;
        $token = Session::get('cart_token');

        if (!$token) return;

        $guestCart = Cart::where('token', $token)->first();

        if (!$guestCart || $guestCart->user_id) return;

        $userCart = Cart::where('user_id', $user->id)->first();

        if ($userCart) {
            foreach ($guestCart->items as $guestItem) {
                $existing = $userCart->items()->where('product_id', $guestItem->product_id)->first();

                if ($existing) {
                    $existing->increment('quantity', $guestItem->quantity);
                } else {
                    $userCart->items()->create([
                        'product_id' => $guestItem->product_id,
                        'quantity' => $guestItem->quantity,
                        'price' => $guestItem->price,
                    ]);
                }
            }

            $guestCart->delete();
        } else {
            $guestCart->update(['user_id' => $user->id]);
        }

        Session::put('cart_token', $userCart ? $userCart->token : $guestCart->token);
    }
}
