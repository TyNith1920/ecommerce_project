<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Stripe\Exception\ApiErrorException;

class StripeTokenController extends Controller
{
    
    public function show($amount)
    {
        
        $value = number_format((float)$amount, 2, '.', '');
        return view('home.stripe_form', compact('value'));
    }

    
    public function charge(Request $request, $amount)
    {
        $request->validate([
            'stripeToken'      => 'required|string',
            'card-holder-name' => 'nullable|string|max:190',
        ]);

        if (!is_numeric($amount) || $amount <= 0) {
            return back()->with('error', 'Invalid amount.');
        }

        $value         = number_format((float)$amount, 2, '.', '');
        $amountInCents = (int) round($value * 100);

        try {
            Stripe::setApiKey(config('stripe.secret')); // STRIPE_SECRET

            $charge = Charge::create([
                'amount'      => $amountInCents,
                'currency'    => config('stripe.currency', 'usd'),
                'description' => 'LFCShop Order #' . Str::upper(Str::random(6)),
                'source'      => $request->input('stripeToken'),
                'metadata'    => [
                    'customer_name' => $request->input('card-holder-name', 'Guest'),
                ],
            ]);

            // TODO: update orders table here if you want

            
            // \App\Models\Cart::where('user_id', auth()->id())->delete();

            return back()->with('success', 'Payment successful! Charge ID: ' . $charge->id);

        } catch (CardException $e) {
            return back()->with('error', 'Card declined: ' . $e->getError()->message);
        } catch (ApiErrorException $e) {
            return back()->with('error', 'Stripe API error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
