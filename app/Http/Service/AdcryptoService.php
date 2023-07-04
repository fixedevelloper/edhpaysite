<?php


namespace App\Http\Service;


use authDTO;
use checkCurrencyExchange;
use checkCurrencyExchangeRequest;
use createBitcoinInvoice;
use createBitcoinInvoiceRequest;
use currencyExchange;
use currencyExchangeRequest;
use getBalances;
use http\Exception;
use MerchantWebService;
use validationCurrencyExchange;
require_once("MerchantWebService.php");
class AdcryptoService
{
private $merchantWebService;
private $arg0;
private  $arg1;
    /**
     * AdcryptoService constructor.
     */
    public function __construct()
    {
        $this->merchantWebService = new MerchantWebService();

        $this->arg0 = new authDTO();
        $this->arg0 ->apiName = "Merchant ecommerce";
        $this->arg0 ->accountEmail = "agensic.solution@gmail.com";
        $this->arg0 ->authenticationToken = $this->merchantWebService->getAuthenticationToken(env("ADVCRYPTO_PASSWORD"));
    }
    public function makeExchanche(){
        $arg1 = new currencyExchangeRequest();
        $arg1->from = "USD";
        $arg1->to = "EUR";
//$arg1->action = "BUY";
        $arg1->action = "SELL";
        $arg1->amount = 1.00;
        $arg1->note = "note";

        $arg2 = new checkCurrencyExchangeRequest();
        $arg2->from = "USD";
        $arg2->to = "BTC";
//$arg1->action = "BUY";
        $arg2->action = "SELL";
        $arg2->amount = 100;

        $validationCurrencyExchange = new validationCurrencyExchange();
        $validationCurrencyExchange->arg0 = $this->arg0;
        $validationCurrencyExchange->arg1 = $arg1;

        $currencyExchange = new currencyExchange();
        $currencyExchange->arg0 = $this->arg0;
        $currencyExchange->arg1 = $arg1;

        $checkCurrencyExchange = new checkCurrencyExchange();
        $checkCurrencyExchange->arg0 = $this->arg0;
        $checkCurrencyExchange->arg1 = $arg2;

        try {
            echo print_r($this->merchantWebService->checkCurrencyExchange($checkCurrencyExchange));
            $this->merchantWebService->validationCurrencyExchange($validationCurrencyExchange);
            $currencyExchangeResponse = $this->merchantWebService->currencyExchange($currencyExchange);

            echo print_r($currencyExchangeResponse, true)."<br/><br/>";
            echo $currencyExchangeResponse->return."<br/><br/>";
        } catch (Exception $e) {
            echo "ERROR MESSAGE => " . $e->getMessage() . "<br/>";
            echo $e->getTraceAsString();
        }
    }
    public function getBalance(){
        $getBalances = new getBalances();
        $getBalances->arg0 = $this->arg0;

        try {
            $getBalancesResponse = $this->merchantWebService->getBalances($getBalances);

            echo print_r($getBalancesResponse, true)."<br/><br/>";
            echo print_r($getBalancesResponse->return, true)."<br/><br/>";
        } catch (Exception $e) {
            echo "ERROR MESSAGE => " . $e->getMessage() . "<br/>";
            echo $e->getTraceAsString();
        }
    }
    public function createBitcoin(){
        $arg1 = new createBitcoinInvoiceRequest();
        $arg1->amount = 1100.00;
        $arg1->currency = "USD";
// optional
        $arg1->sciName = "EDHPAY";
        $arg1->orderId = "12345";
        $arg1->note = "note";

        $createBitcoinInvoice = new createBitcoinInvoice();
        $createBitcoinInvoice->arg0 = $this->arg0;
        $createBitcoinInvoice->arg1 = $arg1;

        try {
            echo print_r($this->merchantWebService->createBitcoinInvoice($createBitcoinInvoice));
        } catch (Exception $e) {
            echo "ERROR MESSAGE => " . $e->getMessage() . "<br/>";
            echo $e->getTraceAsString();
        }
    }
}
