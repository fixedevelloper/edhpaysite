<?php


namespace App\Http\Controllers\Front;


use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Http\Service\AdcryptoService;
use App\Http\Service\CinetPayService;
use App\Http\Service\CryptomusService;
use App\Http\Service\EDHPayService;
use App\Http\Service\EkolopayService;
use App\Http\Service\FlutterwareService;
use App\Http\Service\PaydunyaService;
use App\Http\Service\PaypalService;
use App\Http\Service\StripeService;
use App\Models\Categorie;
use App\Models\LineProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class FrontController extends Controller
{
    private $logger;
    private $flutterservice;
    private $paydunyaService;
    private $paypalService;
    private $edhpayService;
    private $cryptomusService;
    private $advCryptoService;
    private $cinetPayService;
    private $ekolopayService;

    /**
     * FrontController constructor.
     * @param AdcryptoService $adcryptoService
     * @param CryptomusService $cryptomusService
     * @param EDHPayService $edhpayService
     * @param PaydunyaService $paydunyaService
     * @param FlutterwareService $flutterservice
     * @param LoggerInterface $logger
     * @param PaypalService $paypalService
     */
    public function __construct(AdcryptoService $adcryptoService,CryptomusService $cryptomusService,
                                EDHPayService $edhpayService,PaydunyaService $paydunyaService,
                                FlutterwareService $flutterservice,EkolopayService $ekolopayService,CinetPayService $cinetPayService,
                                LoggerInterface $logger,PaypalService $paypalService)
    {
        $this->logger = $logger;
        $this->flutterservice = $flutterservice;
        $this->paydunyaService=$paydunyaService;
        $this->paypalService=$paypalService;
        $this->edhpayService=$edhpayService;
        $this->cryptomusService=$cryptomusService;
        $this->advCryptoService=$adcryptoService;
        $this->ekolopayService=$ekolopayService;
        $this->cinetPayService=$cinetPayService;
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
      if (is_null(session()->get('currency'))){
          Session::put('currency', "XAF");
      }
        return view('front.home', [
            'soins' => $soins,
            'allItems' => $allItems,
            'categories' => $categories,
            'features' => $features,
            'recents' => $recents,
            'change'=>helpers::setPrice(\session()->get('currency')),
        ]);
    }

    public function contact(Request $request)
    {
        return view('front.contact', [

        ]);
    }
    public function service(Request $request){
        return view('front.service', [

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
            'products' => $products,
            'change'=>helpers::setPrice(\session()->get('currency')),
        ]);
    }
    public function categorieproducts($slug){
        $categorie=Categorie::query()->firstWhere(['slug'=>$slug]);
        $products=Product::query()->where('categorie_id','=',$categorie->id)->latest()->paginate(Helpers::pagination_limit());
        return view('front.categorieproducts', [
            'products' => $products,
            'categorie'=>$categorie,
            'change'=>helpers::setPrice(\session()->get('currency')),
        ]);
    }
    public function checkout(Request $request)
    {
        $customer = Auth::user();
        if (!isset($customer)) {
            return redirect()->route('logincustomer');
        }
        $products = Session::get("products");
        $total = 0.0;
        $arrays = [];
        foreach ($products as $item) {
            $soin = Product::query()->find($item['id']);
            if (isset($soin)) {
                $arrays[] = [
                    'item' => $soin,
                    'quantity' => $item['quantity']
                ];
                $total += $soin->sale_price * $item['quantity'];
            }
        }
        if ($request->method() == "POST") {
            $orderkey=Uuid::uuid4();
            $reservation = new Order();
            $reservation->payment_method = $request->get('payement_method');
            $reservation->status = Order::PENDING;
            $reservation->currency = session()->get('currency');
            $reservation->numero = "XAF";
            $reservation->order_key = $orderkey;
            $reservation->total = 0.0;
            $reservation->user_id = $customer->id;
            $reservation->save();
            $products = Session::get("products");
            $total = 0.0;
            $arrays = [];
            foreach ($products as $item) {
                $soin = Product::query()->find($item['id']);
                if (isset($soin)) {
                    $prestation = new LineProduct();
                    $prestation->order_id = $reservation->id;
                    $prestation->product_id = $soin->id;
                    $prestation->quantite = $item['quantity'];
                    $prestation->save();
                    $total += $soin->sale_price * $item['quantity'];
                }
                $arrays[] = $prestation;
            }
            $reservation->update([
                'totaltva' => $total * 0,
                'totalht' => $total,
                'total' => $total + ($total * 0)
            ]);
            $data = ['reservation' => $reservation, 'prestations' => $arrays, "subject" => "Nouvelle reservation", 'message' => '', 'customer' => $reservation->customer];
            // helpers::send_reservation_active($data);
            Session::remove("soin_id");
            Session::remove("products");
            Session::remove("start");
            Session::remove("date");
            Session::remove("user_id");
            if ($request->get('payement_method')=="fluterwave"){
                $response = $this->flutterservice->makeCollet([
                    'ref' => $orderkey,
                    "amount" => $total,
                    "email" => $customer->email,
                    "name" => $customer->name,
                    "phone" => $customer->phone,
                    'currency' => "XAF",
                    'redirect_url' => route('redirectpayement')
                ]);
                return redirect($response['data']['link']);
            }
            if ($request->get('payement_method')=="paydunya"){
                $response = $this->paydunyaService->make_payment([
                    "amount" => $total,
                    'order_key' => $orderkey,
                ]);
                return $response;
            }
            if ($request->get('payement_method')=="edhpay"){
                return redirect()->route('connectedhpay',['token'=>$orderkey]);
            }
            if ($request->get('payement_method')=='paypal'){
               return $this->paypalService->payWithpaypal(['amount'=>$total,
                   'name'=>$customer->name,'order_key'=>$orderkey]);
            }
            if ($request->get('payement_method')=='stripe'){
                return StripeService::payment_process_3d(['amount'=>$total,'ref'=>$orderkey]);
            }
            if ($request->get('payement_method')=='cryptomus'){
                return $this->cryptomusService->make_payment([
                    "amount" => $total,
                    'order_key' => $orderkey,
                    'order_id'=>$reservation->id
                ]);
            }
            if ($request->get('payement_method')=='cinetpay'){
              $response = $this->cinetPayService->sendPayment([
                    'transaction_id' => $orderkey,
                    "amount" => $total,
                    'currency' => "XAF",
                    'description' => "Paiement",
                    'customer_name' => $customer->name,
                    'customer_surname' => "",
                    'customer_country' => "CD",
                    'customer_phone_number' => $customer->phone,
                    'notify_url' => route('redirectpayement'),
                    'return_url' => route('redirectpayement')
                ]);
                return redirect($response['message']);
          /*      return view('front.payment.cinetpay', [
                    "apikey" => env('CINET_APIKEY'),
                    "site_id" => env('CINET_SITEID'),
                    "notify_url" => route('redirectpayement'),
                    "amount" => $total,
                    'currency'=>"XAF",
                    "customer_country" => "CG",
                    "customer_phone_number" => $customer->phone,
                    "customer_surname"=> "",
                    "customer_name"=> $customer->name,
                    "channels" => "ALL",
                    "metadata" => "",
                    "alternative_currency" => "USD",
                    "customer_email" => "exemple@wetransfercash.com",
                    "customer_address" => "kinshasa",
                    "customer_city" => "kinshasa",
                ]);*/
            }

        }
        return view('front.checkout', [
            "soins" => $arrays,
            "total" => $total,
            "start" => session('start'),
            "date" => session('date'),
            'change'=>helpers::setPrice(\session()->get('currency')),
        ]);
    }

    public function currencychange(Request $request)
    {
        Session::put('currency', $request->get('currency'));
        return back();
    }

    public function detailproduct($slug, Request $request)
    {
        $soin = Product::query()->where(['slug' => $slug])->first();

        return view('front.detail_product', [
            'product' => $soin,
            'change'=>helpers::setPrice(\session()->get('currency')),
        ]);

    }
    public function detailorder($order_key){
        $order=Order::query()->where(['order_key'=>$order_key])->first();
        $lines=LineProduct::query()->where(['order_id'=>$order->id])->get();
        return view('front.detailorder', [
            'order' => $order,
            'change'=>helpers::setPrice(\session()->get('currency')),
            'lines'=>$lines
        ]);
    }

    public function cart(Request $request)
    {
        $arrays = [];

        $soins = Session::get("products");
        $total = 0.0;
        if (isset($soins)) {
            foreach ($soins as $item) {
                $soin = Product::query()->find($item['id']);
                if (isset($soin)) {
                    $arrays[] = [
                        'item' => $soin,
                        'quantity' => $item['quantity']
                    ];
                    $total += $soin->sale_price * $item['quantity'];
                }
            }
        }

        return view('front.cart', [
            'totalht' => $total,
            'totaltva' => $total * 0,
            'total' => $total + ($total * 0),
            'change'=>helpers::setPrice(\session()->get('currency')),
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

    public function addcart(Request $request)
    {
        $arrays = [];
        Session::push('products', [
            'id' => $request->get('id'),
            'quantity' => $request->get('quantity')
        ]);

        $products = Session::get("products");

        Session::put('products', array_unique($products, SORT_REGULAR));
        $total = 0.0;
        foreach (array_unique($products, SORT_REGULAR) as $item) {
            $product = Product::query()->find($item['id']);
            if (isset($product)) {
                $arrays[] = $product;
                $total += $product->sale_price * $item['quantity'];
            }
        }
        return redirect()->route('cart');
    }

    public function testpayement(Request $request)
    {
       /* $response = $this->flutterservice->makeCollet([
            'ref' => "1254788",
            "amount" => 2000,
            'currency' => "XAF",
            'redirect_url' => route('redirectpayement')
        ]);

        logger($response);
        return redirect($response['data']['link']);*/
       /* return $this->paydunyaService->make_payment(['amount'=>2000,
            'order_key'=>25147888]);*/
      //return  StripeService::payment_process_3d(['amount'=>2000]);
       // return $this->paypalService->payWithpaypal(['amount'=>2000,'name'=>"Rodrigue mbah"]);
      // $val=$this->edhpayService->connect();
       //logger($val['content']);
       // $this->advCryptoService->createBitcoin();
        /*return view('front.bicoinsell', [

        ]);*/
       /* $response = $this->cinetPayService->sendPayment([
            'transaction_id' => "1254788",
            "amount" => 2000,
            'currency' => "XAF",
            'description' => "Paiement",
            'customer_name' => "Mbah",
            'customer_surname' => "Rodrigue",
            'customer_country' => "CM",
            'customer_phone_number' => "237675066919",
            'notify_url' => route('redirectpayement'),
            'return_url' => route('redirectpayement')
        ]);
       return redirect($response['message']);*/
        $response = $this->ekolopayService->postRequest([
            'transaction_id' => "1254788",
            "amount" => 2000,
            'currency' => "XAF",
            'name' => "Mbah",
            'phone' => "066304925",
            'notify_url' => route('redirectpayement'),
            'return_url' => route('redirectpayement')
        ]);
        $this->ekolopayService->sentUserAgent($response['message']);
    }

    public function redirectpayement(Request $request)
    {
        logger($request->toArray());
        if ($request->get('status')=="successful"){
            $id_cmd=Session::get('tnx');
            $order=Order::query()->find($id_cmd);
            $order->update([
                'status'=>Order::COMPLETED
            ]);
            return redirect()->route('paymentsuccess');
        }else{
            return redirect()->route('paymentfail');
        }
    }
}
