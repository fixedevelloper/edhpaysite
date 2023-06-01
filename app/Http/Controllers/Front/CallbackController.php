<?php


namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Http\Service\PaypalService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CallbackController extends Controller
{
    private $paypalService;

    /**
     * CallbackController constructor.
     * @param $paypalService
     */
    public function __construct(PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;
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
            $o = explode('_', $txn_ref);
            $order_id = intval( $o[1] );
            $order=Order::query()->where(['order_key'=>$order_id])->first();
            $order->update([
               'status'=>Order::COMPLETED
            ]);
        }else{
            $txn_ref = $request->get('tx_ref');
            logger("---------".request()->tx_ref);
            $order=Order::query()->where(['order_key'=>$txn_ref])->first();
            $order->update([
                'status'=>Order::REFUSED
            ]);
            return redirect()->route('callback.payment-fail');
        }
    }
}
