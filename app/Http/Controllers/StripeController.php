<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        // កំណត់ API key
        Stripe::setApiKey(config('stripe.secret'));

        // បង្កើត session បង់ប្រាក់
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Order #' . uniqid(),
                    ],
                    'unit_amount' => $request->input('amount', 500) * 100, // $5.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function success(Request $request)
    {
        return view('home.stripe_success');
    }

    public function cancel()
    {
        return view('home.stripe_cancel');
    }
}
