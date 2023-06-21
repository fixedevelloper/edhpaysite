<?php


namespace App\Http\Service;


use App\Helpers\helpers;
use Cryptomus\Api\Client;
use Cryptomus\Api\Payment;
use Cryptomus\Api\Payout;

class CryptomusService
{
    /**
     * @var Payment
     */
    private $payment;
    /**
     * @var Payout
     */
    private $payout;
    private $logger;
    private $merchant_uuid;
    private $apikey;
    /**
     * CryptomusService constructor.
     * @param Payment $payment
     * @param Payout $payout
     */
    public function __construct()
    {

        $this->apikey=env('CRYTOMUS_APIKEY');
        $this->merchant_uuid=env('CRYTOMUS_UUID');
        $this->payout = Client::payout(env("CRYTOMUS_APIKEY"), $this->merchant_uuid);;
        $this->payment = Client::payment(env('CRYTOMUS_APIKEY'), $this->merchant_uuid);;
    }
    public function make_payment($data){
        try {
            $payment = $this->payment->create([
                'amount' => $data['amount']*helpers::setPrice(session('currency')),
                'currency' => "XAF",
                'order_id' => $data['order_id'],
                'url_return' => route('callback.payment-succes'),
                'url_callback' => route('callback.callbackcryptomuss',['order_key'=>$data['order_key'],'order_id'=>$data['order_id']]),
                'is_payment_multiple' => true,
                'lifetime' => 7200,
                'subtract' => '1',
            ]);
            return redirect($payment['url']);
        } catch (\Exception $e) {
            logger($e);
            return \redirect()->route('callback.payment-fail');
        }
    }
}
