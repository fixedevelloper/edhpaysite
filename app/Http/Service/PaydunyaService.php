<?php


namespace App\Http\Service;


use App\Helpers\helpers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class PaydunyaService
{
    /**
     * @var Client
     */
    private $client;
    /**
     * FlutterwareService constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env("PAYDUNYA_URL"),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json charset=UTF-8 ',

            ],
        ]);
    }
    public function make_payment($value)
    {
        logger(">>>>>++++ PAYDUNYA MAKE PAYEMENT");
        $currency_code = "XAF";
        try {
            $order = $this->createOrder($value);
            $options = [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    "PAYDUNYA-MASTER-KEY"=>env("PAYDUNYA_PRINCIPAL"),
                    "PAYDUNYA-PRIVATE-KEY"=>env("PAYDUNYA_SECRET_KEY"),
                    "PAYDUNYA-TOKEN"=>env("PAYDUNYA_TOKEN")
                ],
                'body' => json_encode($order)
            ];
            $res = $this->client->post("checkout-invoice/create",$options);
            $response= $res->getBody();
           // $response = $this->cURL($this->base_url . "checkout-invoice/create", $order);
            logger(">>>>>++++ PAYDUNYA MAKE PAYEMENT" . $response);
            $response_decoded = json_decode($response,true);
            if ($response_decoded['response_code'] && $response_decoded['response_code'] == "00") {
                Session::put('paydunya_transaction', $order['custom_data']['trans_id']);
                return redirect($response_decoded['response_text']);

            } else {
                return \redirect()->route('callback.payment-fail');
            }
        } catch (\Exception $exception) {
            logger(">>>>>++++ PAYDUNYA EXCEPTION" . $exception);
            return \redirect()->route('callback.payment-fail')->withErrors(['error' => 'Failed']);
        }
        return $response;
    }

    public function createOrder($values)
    {
       logger(">>>>>++++ PAYDUNYA CREATE ORDER");
        $value = $values['amount'];
        $txnid = $values['order_key'];
        $str = "$value|||||||||||$txnid";
        $hash = hash('sha512', $str);
        $data = []; //items will be here
        $data['amount'] = $value;
        $paydunya_items[] = [
            "name" => "merchant paid",
            "quantity" => 1,
            "unit_price" => $data['amount']*helpers::setPrice(session('currency')),
            "total_price" => $data['amount']*helpers::setPrice(session('currency')),
            "description" => ""
        ];
        $paydunya_args = [
            "invoice" => [
                "items" => $paydunya_items,
                "total_amount" => $data['amount']*helpers::setPrice(session('currency')),
                "description" => "Paiement de " . $data['amount']*helpers::setPrice(session('currency')) . " pour".session('currency')." recharge de compte sur " . "EDHPay"
            ], "store" => [
                "name" => "EDHPay",
                "website_url" => "https://edhpay.com"
            ], "actions" => [
                "cancel_url" => route('callback.payment-fail'),
                "callback_url" => route('callback.callbackpaydunya').'?txnid='.$txnid,
                "return_url" => route('callback.payment-succes')
            ], "custom_data" => [
                "order_id" => 1,
                "trans_id" => $txnid,
                "to_user_id"=>2,
                "hash" => $hash
            ]
        ];
        logger(">>>>>++++ PAYDUNYA ORDER" . json_encode($paydunya_args));
        return $paydunya_args;
    }
}
