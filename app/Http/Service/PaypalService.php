<?php


namespace App\Http\Service;


use App\Helpers\helpers;
use App\Models\Order;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalService
{
    /**
     * @var ApiContext
     */
    private $_api_context;

    public function __construct()
    {
        $this->_api_context = new ApiContext(new OAuthTokenCredential(env("PAYPAL_CLIENT"),
                env("PAYPAL_SECRET"))
        );
        $config = array(
            'client_id' => env("PAYPAL_CLIENT"), // values : (local | production)
            'secret' => env("PAYPAL_SECRET"),
            'settings' => array(
                'mode' => env('PAYPAL_MODE', 'live'), //live||sandbox
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'ERROR'
            ),
        );
        logger($config['settings']);
        $this->_api_context->setConfig(array(
            'mode' => env('PAYPAL_MODE', 'live'), //live||sandbox
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        ));
    }

    public function payWithpaypal($values)
    {
        $tr_ref = Str::random(6) . '-' . rand(1, 1000);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $pay_amount = $values['amount']*helpers::setPrice(session('currency'));

        $items_array = [];
        $item = new Item();
        $item->setName($values['name'])
            ->setCurrency("USD")
            ->setQuantity(1)
            ->setPrice($pay_amount);
        array_push($items_array, $item);

        $item_list = new ItemList();
        $item_list->setItems($items_array);

        $amount = new Amount();
        $amount->setCurrency(session('currency'))
            ->setTotal($pay_amount);

        \session()->put('transaction_reference', $tr_ref);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($tr_ref);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('callback.paypal-status'))
            ->setCancelUrl(URL::route('callback.payment-fail'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setId($values['order_key'])
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {

            $payment->create($this->_api_context);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            Session::put('paypal_payment_id', $payment->getId());
            if (isset($redirect_url)) {
                return Redirect::away($redirect_url);
            }

        } catch (\Exception $ex) {
            // Toastr::error('Your currency is not supported by PAYPAL.');
            logger($ex);
            return back()->withErrors(['error' => 'Failed']);
        }

        Session::put('error', 'Configure your paypal account.');
        return back()->withErrors(['error' => 'Failed']);
    }
    public function getPaymentStatus(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request['PayerID']);

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        $order=Order::query()->where(['order_key'=>$payment_id])->first();
        if ($result->getState() == 'approved') {

            $order->update(['status'=>Order::COMPLETED]);
            return redirect()->route('callback.payment-succes');
        }else{
            $order->update(['status'=>Order::REFUSED]);
            return redirect()->route('callback.payment-fail');
        }
    }
}
