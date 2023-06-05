<?php


namespace App\Http\Controllers\Front;


use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\LineProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\s;

class AccountController extends Controller
{
    public function account(Request $request)
    {
        $user=Auth::user();
        $historiques=Order::query()->where('user_id','=',$user->id)
            ->where(['status'=>Order::COMPLETED])
            ->latest()->paginate(Helpers::pagination_limit());
        $lines=LineProduct::query()->leftJoin('orders','line_products.order_id','=','orders.id')
            ->leftJoin('products','line_products.product_id','=','products.id')
            ->where(['orders.user_id'=>$user->id,'orders.status'=>Order::COMPLETED])->paginate(Helpers::pagination_limit());

        $downloads=[];
        foreach ($lines as $line){
            if ($line->product->isdownloable){
                $downloads[]=$line;
            }
        }
        return view('front.account', [
            'historiques'=>$historiques,
            'downloads'=>$downloads,
            'user'=>$user
        ]);
    }
    public function downloadFile($id)
    {
        $product=Product::query()->find($id);
        return response()->download(public_path('storage/downloads/'.$product->downloable_file));
    }
    public function historique(Request $request)
    {
        return view('front.historique', []);
    }
    public function profil(Request $request)
    {
        $user = Auth::user();
        if ($request->method() == "POST") {
            $user->update([
                "name" => $request->get('firstname'),
                "lastname" => $request->get('lastname'),
                "phone" => $request->get('phone'),
                "adresse" => $request->get('adresse'),
                // "adressepostal" => $request->get('adressepostal'),
                //"commune" => $request->get('commune'),
                "email" => $request->get('email'),
                // 'password' => bcrypt($request->get('password')),
            ]);
            return redirect('profil');
        }
        return view('auth.profil', ['user' => $user]);
    }

}
