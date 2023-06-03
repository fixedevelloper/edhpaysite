<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\LineProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class shopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $agents = User::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Shop();
        }

        $agents = $agents->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.shop.index', compact('agents', 'search'));
    }
    public function paiement(Request $request){
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $agents = Reservation::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('date_reservation', 'like', "%{$value}%")
                        ->orWhere('heure_reservation', 'like', "%{$value}%")
                    ;
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Reservation();
        }

        $agents = $agents->Caisse()->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.caisse.paiement', compact('agents', 'search'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.caisse.create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            //'image' => 'required',
            'email' => 'required|unique:users|min:4|max:20',
            'phone' => 'required|unique:users|min:8|max:20',
            'adresse' => 'required',
            'password' => 'required|min:4|max:14',
        ],[
            'password.min' => 'Password must contain 4 characters',
            'password.max' => 'Password must contain 4 characters',
        ]);

        $email = $request->email;
        $agent = User::where(['email' => $email])->first();
        if (isset($agent)){
            //  Toastr::warning(translate('This phone number is already taken'));
            return back();
        }

        DB::transaction(function () use ($request, $email) {
            $user = new User();
            $user->name = $request->f_name;
            $user->lastname = $request->l_name;
            //$user->image = Helpers::upload('agent/', 'png', $request->file('image'));
            $user->email = $request->email;
            $user->adresse = $request->adresse;
            $user->phone = $request->phone;;
            $user->role = 'ROLE_CAISSE';
            //   $user->occupation = $request->occupation;
            $user->password = bcrypt($request->password);
            $user->user_type = 3;    //['Admin'=>0, 'Agent'=>1, 'Customer'=>2, 'Caisse'=>3]
            $user->save();
        });

        // Toastr::success(translate('Agent Added Successfully!'));
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        $lines=LineProduct::query()->leftJoin('orders','line_products.order_id','=','orders.id')
            ->leftJoin('products','line_products.product_id','=','products.id')
            ->where(['products.shop_id'=>$id,'orders.status'=>Order::COMPLETED])->get();
        $total_vente=0.0;
        foreach ($lines as $line){
          $total_vente+=$line->product->sale_price*$line->quantite;
        }
        $current_solde=$total_vente-$shop->retrait;
        return view('back.shop.show', compact('shop','lines','total_vente','current_solde'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('back.shop.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $conge = User::find($id);
        $conge->update([
            'lastname' => $request->lastname,
            'name' => $request->name,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'phone' => $request->phone,
        ]);
        return redirect()->route('caisse.index');
    }

    /**
     * Remove the specified resource from storage.
     */

        public function destroy(Request $request)
    {
        $id=$request->get('item');
        $conge = User::query()->find($id);
        $conge->delete();
        return response()->json(['data' => $conge, 'status' => true]);

    }
}
