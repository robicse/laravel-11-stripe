<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public function index()
    {
        return view('stripe');
    }

    public function charge(Request $request)
    {
        // dd($request->all());
        // \Log::info($request->stripeToken);

        $request->validate([
            'stripeToken' => 'required|string',
            'price' => 'required|numeric|min:1',
        ]);

        $stripe = new StripeClient(env('STRIPE_SECRET'));


        $charge = $stripe->charges->create([
            'amount' => $request->price * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Payment from Stripe',
        ]);
        return back()->withSuccess('Payment successful!');
    }
}
