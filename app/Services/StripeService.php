<?php

namespace App\Services;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
           Stripe::setApiKey(config('services.stripe.secret'));
    }
     public function createCheckoutSession(array $lineItems): string
    {
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
             
            'success_url' => route('checkout.success'),
            'cancel_url' => route('home', ['cancelled' => true]),
        ]);

        return $session->url;
    }
}
