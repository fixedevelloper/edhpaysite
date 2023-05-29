<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
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
            $agents = Order::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Order();
        }

        $agents = $agents->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.order.index', compact('agents', 'search'));
    }
    public function accepted(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $agents = Order::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Order();
        }

        $agents = $agents->newQuery()->where(['status'=>Order::COMPLETED])->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.order.index', compact('agents', 'search'));
    }
    public function pending(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $agents = Order::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Order();
        }

        $agents = $agents->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.order.index', compact('agents', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $produits=Product::all();
        $customers=User::query()->customer()->get();
        if ($request->method()=="POST"){
            $data = json_decode($request->getContent(), true);
            $customer_id = $data['customer_id'];
            $ob = $data['ob'];
            $facture=new Facture();
            $facture->numero="0214";
            $facture->date_facture=date('Y-m-d');
           $facture->montantht=0.0;
            $facture->tva=0;
            $facture->montantttc=0;
            $facture->reduction=0;
            $facture->adresse="PAID";
            $facture->typefacture="products";
            $facture->customer_id=$customer_id;
            $facture->save();
            $total=0;
            for ($i = 0; $i < sizeof($ob); ++$i) {
                $product = Product::query()->find($ob[$i]['id']);

                $facture->products()->attach($product->id);
                $quantity = $ob[$i]['quantity'];
                $total+=($product->price_sell*$quantity);
            }
            $facture->update([
                'montantht'=>$total,
                'tva'=>$total*0.21,
                'montantttc'=>$total+($total*0.21),
            ]);
            return response()->json(['data' => $facture, 'status' => true]);
        }
        return view('back.facturation.create', compact('produits','customers'));
    }
    public function customer(Request $request)
    {
        if ($request->method()=='POST'){
            User::factory()->create([
                "name" => $request->get('firstname'),
                "lastname" => $request->get('lastname'),
                "phone" => $request->get('phone'),
                "adresse" => $request->get('adresse'),
                "email" => $request->get('email'),
                "user_type" => 2,
                "role" => "ROLE_USER",
                'password' => bcrypt($request->get('password')),
            ]);
            return redirect()->route('facturation.create');
        }
        return view('back.facturation.customer');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $facturation=new Facture();
        $soin=Soin::query()->find($request->get('soin_id'));

        $facturation->montantht=$soin->price;
        $facturation->soin_id=$soin->id;
        $facturation->customer_id=$request->get('customer_id');
        $facturation->user_id=$request->get('user_id');
        $facturation->date_facture=date('Y-m-d');
        $facturation->montantttc=$soin->price;
        $facturation->numero=0;
        $facturation->tva=0;
        $facturation->reduction=0;
        $facturation->adresse=012;
        $facturation->save();
      return  redirect()->route('facturation.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Facture $facture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $facture=Order::query()->find($id);
        $estheticiens=User::query()->estheticien()->get();
        $customers=User::query()->customer()->get();
        return view('back.order.update', compact('estheticiens','customers','soins','facture'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $facture=Facture::query()->find($id);
        $facture->update([
          'soin_id'=>$request->get('soin_id'),
            'user_id'=>$request->get('user_id'),
            'customer_id'=>$request->get('customer_id'),
        ]);
        return  redirect()->route('facturation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->get('item');
        $conge = Facture::query()->find($id);
        $conge->delete();
        return response()->json(['data' => $conge, 'status' => true]);
    }
}
