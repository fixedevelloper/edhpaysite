<?php


namespace App\Http\Controllers\Front;


use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Http\Service\EDHPayService;
use App\Http\Service\PaypalService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CallbackController extends Controller
{
    private $paypalService;
    private $edhpayService;

    /**
     * CallbackController constructor.
     * @param $paypalService
     */
    public function __construct(EDHPayService $edhpayService,PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;
        $this->edhpayService=$edhpayService;
    }
    public function callbackstripecancell(){
        $orderkey=session()->get('transaction_stripe_ref');
        $order=Order::query()->where(['order_key'=>$orderkey])->first();
        $order->update([
            'status'=>Order::REFUSED
        ]);
        return redirect()->route('callback.payment-fail');
    }
    public function callbackstripesuccess(){
        $orderkey=session()->get('transaction_stripe_ref');
        $order=Order::query()->where(['order_key'=>$orderkey])->first();
        $order->update([
            'status'=>Order::COMPLETED
        ]);
        return redirect()->route('callback.payment-succes');
    }
    public function callbackpaydunya(Request $request){
        $status = $_POST['data']['status'];
        if ($status == 'completed') {
            $transactionID = $_POST['data']['custom_data']['trans_id'];
            $order=Order::query()->where(['order_key'=>$transactionID])->first();
            $order->update([
                'status'=>Order::COMPLETED
            ]);
        }elseif ($status == 'failed'){
            $transactionID = $_POST['data']['custom_data']['trans_id'];
            $order=Order::query()->where(['order_key'=>$transactionID])->first();
            $order->update([
                'status'=>Order::REFUSED
            ]);
        }
    }
    public function paypalstatus(Request $request){
        $this->paypalService->getPaymentStatus($request);
    }
    public function paymentsucces(Request $request){
        return view('front.paymentsucces', [
        ]);
    }
    public function paymentfail(Request $request){
        return view('front.paymentfail', [
        ]);
    }
    public function callbackflutterware(Request $request){
        $status =$request->get("status");
        if ($status == 'successful') {
            $txn_ref = request()->tx_ref;
          //  $o = explode('_', $txn_ref);
            $order=Order::query()->where(['order_key'=>$txn_ref])->first();
            $order->update([
               'status'=>Order::COMPLETED
            ]);
            return redirect()->route('callback.payment-succes');
        }else{
            $txn_ref = $request->get('tx_ref');
           // logger("---------".request()->tx_ref);
            $order=Order::query()->where(['order_key'=>$txn_ref])->first();
            $order->update([
                'status'=>Order::REFUSED
            ]);
            return redirect()->route('callback.payment-fail');
        }
    }
    public function connectedhpay($token,Request $request){
        $order=Order::query()->where(['order_key'=>$token])->first();
        if ($request->method()=="POST"){
            $data=[
              'phone'=>$request->get('phone'),
              'pin'=>$request->get('pin'),
              'amount'=>$order->total/helpers::setPrice($order->currency)
            ];
           $res= $this->edhpayService->makePayment($data);
           if ($res['message']=="success"){
               $order->update([
                   'status'=>Order::COMPLETED
               ]);
               return redirect()->route('callback.payment-succes');
           }else{
               $order->update([
                   'status'=>Order::REFUSED
               ]);
               return redirect()->route('callback.payment-fail');
           }
        }
        return view('front.connectedhpay', [
            'order'=>$order,
            'change'=>helpers::setPrice($order->currency)
        ]);
    }
    public function callbackcryptomuss(Request $request)
    {
        try {
            // if (isset($_POST['data'])){
            logger(">>>>>++++ CRYTOMUS CALLBACK" . json_encode($_POST['data']));

            $status = $_POST['status'];
            $order=Order::query()->where(['order_key'=>$request->get('order_key')])->first();
            if ($status == 'paid' || $status == 'paid_over') {
                $order->update([
                    'status'=>Order::COMPLETED
                ]);
                return redirect()->route('callback.payment-succes');
            }else{
                $order->update([
                    'status'=>Order::REFUSED
                ]);
                return redirect()->route('callback.payment-fail');
            }
        }catch (\Exception $exception){
            $order->update([
                'status'=>Order::REFUSED
            ]);
            return redirect()->route('callback.payment-fail');
        }
    }
}
