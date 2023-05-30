<?php


namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Request;

class CallbackController extends Controller
{

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
    public function paypalstatus(){

    }
    public function paymentsucces(Request $request){
        return view('front.paymentsucces', [
        ]);
    }
    public function paymentfail(Request $request){
        return view('front.paymentfail', [
        ]);
    }
}
