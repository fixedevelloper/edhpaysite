<?php


namespace App\Http\Service;


use Flutterwave\Contract\ConfigInterface;
use Flutterwave\Flutterwave;
use Flutterwave\Payload;
use Flutterwave\Util\AuthMode;
use Flutterwave\Util\Currency;
use GuzzleHttp\Client;
use http\Exception;

class FlutterwareService
{
    const BASE_URL = "https://api.flutterwave.com/v3/";
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
        Flutterwave::bootstrap();
        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json charset=UTF-8 ',
            ],
        ]);
    }
    public  function makeCollet($data){
        $postdata = [
            'tx_ref' => $data['ref'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'redirect_url' => $data['redirect_url'],
            'meta' => [
                'consumer_id' => 23,
                'consumer_mac' => "92a3-912ba-1192a"
            ],
            'customer' => [
                "full_name" => "Olaobaju Jesulayomi Abraham",
                "email" => "vicomma@gmail.com",
                "phone" => "+2349067985861"
            ],
            'customizations' => [
                'title' => "EDHPay",
                'logo' => "https://edhpay.com/logo.jpg"

            ],
        ];
        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('SECRET_KEY'),
            ],
            'body' => json_encode($postdata)
        ];
        $endpoint ="payments";
        $response = $this->client->post($endpoint,$options);
        $body = $response->getBody();
        return json_decode($body,true);
    }

}
