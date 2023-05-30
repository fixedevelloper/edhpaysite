<?php


namespace App\Http\Service;


use Illuminate\Support\Str;
use Stripe\Stripe;

class StripeService
{
    public static function payment_process_3d($values)
    {
        $tran = Str::random(6) . '-' . rand(1, 1000);
        session()->put('transaction_ref', $tran);

        Stripe::setApiKey(env('STRIPE_APIKEY'));
        header('Content-Type: application/json');
        $currency_code = "XAF";

        $YOUR_DOMAIN = url('/');

        $currencies_not_supported_cents = ['BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'];
        $amount = $values['amount'];
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency_code ?? 'usd',
                    'unit_amount' => in_array($currency_code, $currencies_not_supported_cents) ? (int)$amount : ($amount * 100),
                    'product_data' => [
                        'name' => "EDHPay",
                        'images' => [asset('logo.jpg')]
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/pay-stripe/success',
            'cancel_url' => url()->previous(),
        ]);
        logger($checkout_session);
        // return response()->json(['id' => $checkout_session->id]);
        return redirect($checkout_session->url);
    }

}
