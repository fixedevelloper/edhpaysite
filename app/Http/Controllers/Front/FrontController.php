<?php


namespace App\Http\Controllers\Front;


use App\Helpers\DateTimeHelper;
use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\LineProduct;
use App\Models\Order;
use App\Models\Planing;
use App\Models\Prestation;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Soin;
use App\Models\Soin_type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Psr\Log\LoggerInterface;

class FrontController extends Controller
{
    private $logger;

    /**
     * FrontController constructor.
     * @param $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function home(Request $request)
    {
        $allItems = [];
        $categories = Categorie::all();
        foreach ($categories as $category) {
            $soins = Product::query()->where('categorie_id', '=', $category->id)
                ->get();
            $allItems[] = [
                'category' => $category,
                'soins' => $soins

            ];
        }
        $soins = Product::query()->inRandomOrder()->limit(3)->get();
        $features = Product::query()->orderByDesc('id')->inRandomOrder()->limit(20)->get();
        $recents = Product::query()->orderByDesc('id')->inRandomOrder()->limit(20)->get();
        return view('front.home', [
            'soins' => $soins,
            'allItems' => $allItems,
            'categories'=>$categories,
            'features'=>$features,
            'recents'=>$recents
        ]);
    }

    public function contact(Request $request)
    {
        return view('front.contact', [

        ]);
    }
    public function product(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $agents = Product::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $products = new Product();
        }

        $products = $products->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('front.products', [
            'products'=>$products
        ]);
    }
    public function checkout(Request $request)
    {
        $customer = Auth::user();
        if (!isset($customer)) {
            return redirect()->route('logincustomer');
        }
        $soins = Session::get("products");
        $total=0.0;
        $arrays=[];
        foreach ($soins as $item){
            $soin = Product::query()->find($item['id']);
            if (isset($soin)) {
                $arrays[] = $soin;

                $total += $soin->sale_price*$item['quantity'];
            }
        }
        if ($request->method() == "POST") {

            $reservation = new Order();
            $reservation->payment_method = $request->get('payement_method');
            $reservation->status = Order::PENDING;
            $reservation->currency="XAF";
            $reservation->numero="XAF";
            $reservation->order_key="0254788";
            $reservation->total=0.0;
            $reservation->user_id = session('user_id');
            $reservation->save();
            $soins = Session::get("products");
            $total=0.0;
            $arrays=[];
            foreach ($soins as $item){
                $soin = Product::query()->find($item['id']);
                if (isset($soin)) {
                 $prestation=new LineProduct();
                 $prestation->order_id=$reservation->id;
                 $prestation->product_id=$soin->id;
                 $prestation->save();
                    $total += $soin->sale_price*$item['quantity'];
                }
                $arrays[]=$prestation;
            }
            $reservation->update([
              // 'totaltva'=>$total*0.21,
              //  'totalht'=>$total,
                'total'=>$total+($total*0.21)
            ]);
            $data = ['reservation' => $reservation,'prestations'=>$arrays, "subject" => "Nouvelle reservation", 'message' => '', 'customer' => $reservation->customer];
           // helpers::send_reservation_active($data);
            Session::remove("soin_id");
            Session::remove("products");
            Session::remove("start");
            Session::remove("date");
            Session::remove("user_id");
            return redirect()->route('account');
        }
        return view('front.checkout', [
            "soins" => $arrays,
            "total"=>$total,
            "start" => session('start'),
            "date" => session('date'),
        ]);
    }

    public function checkoutsession(Request $request)
    {
        Session::put('soin_id', $request->get('item'));
        Session::put('start', $request->get('start'));
        Session::put('date', $request->get('date'));
        Session::put('user_id', $request->get('user_id'));

        return response()->json(['data' => "", 'status' => true]);
    }

    public function detailproduct($slug,Request $request)
    {
        $soin = Product::query()->where(['slug' => $slug])->first();

        return view('front.detail_product', [
            'product' => $soin,
        ]);
    }

    public function cart(Request $request)
    {
        $arrays = [];

        $soins = Session::get("products");
        $total = 0.0;
        if (isset($soins)){
            foreach ($soins as $item){
                $soin = Product::query()->find($item['id']);
                if (isset($soin)) {
                    $arrays[] = [
                        'item'=>$soin,
                        'quantity'=>$item['quantity']
                    ];
                    $total += $soin->sale_price*$item['quantity'];
                }
            }
        }

        return view('front.cart', [
            'totalht' => $total,
            'totaltva' => $total*0.21,
            'total' => $total+($total*0.21),
            'soins' => $arrays,
        ]);
    }

    public function removesession(Request $request)
    {
        $soin_id = $request->get('id');
        $soins = Session::get('products');
        $soins = array_filter($soins, function ($tem) use ($soin_id) {
            return $tem['id'] != $soin_id;
        });
        Session::put('products', $soins);
        return redirect()->route('cart');
    }
    public function addcart(Request $request){
        // Session::remove('soins');
        $arrays = [];
        // $soin_s[] = Session::get("soins");
        //if (!array_key_exists($request->get('id'), $soin_s)) {
        Session::push('products', [
            'id'=>$request->get('id'),
            'quantity'=>$request->get('quantity')
        ]);
        //  }
        $soins = Session::get("products");

        Session::put('products', array_unique($soins,SORT_REGULAR));
        $total = 0.0;
        foreach (array_unique($soins,SORT_REGULAR) as $item){
            $soin = Product::query()->find($item['id']);
            if (isset($soin)) {
                $arrays[] = $soin;
                $total += $soin->sale_price*$item['quantity'];
            }
        }
        return redirect()->route('cart');
    }

    public function cartfinal(Request $request)
    {
       // Session::remove("soin_id");
       // $soin_id = Session::get('soins')[2];
        $users = User::query()->where("user_type", "=", 1)->get();
        $soins = Session::get("soins");
        $total=0.0;
        $arrays=[];
        foreach (array_unique($soins) as $item){
            $soin = Soin::query()->find($item);
            if (isset($soin)) {
                $arrays[] = $soin;

                $total += $soin->price;
            }
        }
        return view('front.cartfinal', [
          //  'soin_id' => $soin_id,
            'soins'=>$arrays,
            'users' => $users
        ]);
    }

    public function calculplaning(Request $request)
    {
        $user_id = $request->get('user_id');
        $soin_id = $request->get('item');
        $date_ = $request->get('date');
        $soin = Soin::find($soin_id);
        $soins = Session::get("soins");
        $durre =0;
        foreach (array_unique($soins) as $item){
            $soin = Soin::query()->find($item);
            if (isset($soin)) {
                $durre += DateTimeHelper::getMin($soin->duree);
            }
        }

        $arry = [];
        if ($user_id == 0) {
            $s = strtotime($date_ . " 08:00:00");
            $e = strtotime($date_ . " 18:00:00");
            $arry[] = date('H:i:s', $s);
            while ($s <= $e) {
                $s = strtotime($durre . ' minutes', $s);
                // echo date('H:i', $s);
                $arry[] = date('H:i:s', $s);
            }
        } else {
            $planing = Planing::query()->where('user_id', '=', $user_id)
                ->where('date_planing', '=', $date_)->first();
            $reservations = Reservation::query()->where('user_id', '=', $user_id)
                ->where('date_reservation', '=', $date_)->get();
            $times = array_map(function ($item) {
                return $item['heure_reservation'];
            }, $reservations->toArray());
            if (isset($planing)) {
                $s = strtotime($date_ . " " . $planing->heure_debut);
                $e = strtotime($date_ . " " . $planing->heure_fin);
                $arry[] = date('H:i:s', $s);
                while ($s <= $e) {
                    $s = strtotime($durre . ' minutes', $s);
                    // echo date('H:i', $s);
                    $arry[] = date('H:i:s', $s);
                }
            }
            $arry = array_filter($arry, function ($item) use ($times) {
                $val = true;
                foreach ($times as $time) {
                    if ($item == $time) {
                        $val = false;
                    }
                    // $this->logger->info("###------###".$time);
                    // $this->logger->info("###---item---###".$item);
                }
                return $val;
                //  return  !array_key_exists($item,$times);
            });

        }


        return response()->json(['data' => $arry, 'status' => true]);
    }

    private function generateTimePlaning()
    {

    }
}
