<?php


namespace App\Http\Service;


use App\Helpers\helpers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;

class EDHPayService
{
    const BASE_URL = "https://edhpay.agensic.com";
    private $flutter;
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
            'base_uri' => self::BASE_URL,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json charset=UTF-8 ',
            ],
        ]);
    }
    public function connect($auth){
/*        $auth=[
            'phone'=>"657285051",
            'password'=>"1234",
            'dial_country_code'=>"+237"
        ];
        logger(Hash::make('0000'));*/
        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'device-id'=>"85874",
                'device-model'=>"app.ecommerce",
                'os'=>"localhost"
                // 'Authorization'=> 'Bearer ',
            ],
            'body' => json_encode($auth)
        ];
        $endpoint_login ="/api/v1/customer/auth/login";
        $response = $this->client->post($endpoint_login,$options);
        $body = $response->getBody();
        return json_decode($body,true);
    }
    public function makePayment($data){
        logger(substr($data['phone'],0,4));
        logger(substr($data['phone'],4));
        logger($data['pin']);
        $auth=[
            'phone'=>substr($data['phone'],4),
            'password'=>$data['pin'],
            'dial_country_code'=>substr($data['phone'],0,4)
        ];
       $token= $this->connect($auth);
       $data_=[
           'phone'=>env("RECEIVEREDHPAY"),
           'pin'=>$data['pin'],
           'amount'=>$data['amount']
       ];
        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'device-id'=>"85874",
                'device-model'=>"app.ecommerce",
                'os'=>"localhost",
                'Authorization'=> 'Bearer '.$token['content'],
            ],
            'body' => json_encode($data_)
        ];
        $endpoint ="/api/v1/customer/cash-out";
        try {
            $response = $this->client->post($endpoint,$options);
            $body = $response->getBody();
            return json_decode($body,true);
        }catch (\Exception $exception){
            return redirect()->route('callback.payment-fail')->withErrors($exception->getMessage());
        }

    }
}
