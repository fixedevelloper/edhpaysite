<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Image;
use App\Models\Product;
use App\Models\Product_type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
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
            $agents = new Product();
        }

        $agents = $agents->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        // $fournisseurs=Fournisseur::all();
        $categories = Categorie::all();
        return view('back.product.index', compact('agents', 'search', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('back.product.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
            //'image' => 'required',
            'price_sell' => 'required',
            'price' => 'required',
            'quantite' => 'required',
            'product_type_id' => 'required',
        ]);

        $email = $request->email;
        $agent = Product::where(['libelle' => $email])->first();
        if (isset($agent)) {
            //  Toastr::warning(translate('This phone number is already taken'));
            return back();
        }

        DB::transaction(function () use ($request, $email) {
            $user = new Product();
            $user->libelle = $request->libelle;
            $user->quantity = $request->quantite;
            $user->image = Helpers::upload('product/', 'png', $request->file('image'));
            $user->description = $request->description;
            $user->sale_price = $request->price_sell;
            $user->price = $request->price;
            $user->slug = Str::slug($request->libelle);
            $user->categorie_id = $request->product_type_id;
            $user->isvirtual = $request->virtual == 'on' ? true : false;
            $user->isdownloable = $request->isdownloable == 'on' ? true : false;
            $user->paid_view = $request->paidview;
            $user->free_view = $request->freeview;
            // $user->fournisseur_id = isset($request->fournisseur_id)?$request->fournisseur_id:null;
            if ($request->isdownloable == 'on'){
                $user->downloable_file = Helpers::upload('downloads/', $request->file('downloable_file')->guessExtension(), $request->file('downloable_file'));
                $user->downloable_filename = $request->freeview;
                $user->downloable_expired_date = $request->downloable_day;
            }
            $user->save();
            $image = new Image();
            $image->src = Helpers::upload('images/', $request->file('image')->guessExtension(), $request->file('image'));
            $image->name = $request->file('image')->getFilename();
            $image->alt = $request->file('image')->getFilename();
            $image->position = 0;
            $image->save();
            $user->images()->attach($image->id);
        });

        // Toastr::success(translate('Agent Added Successfully!'));
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Categorie::all();
        return view('back.product.update', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::query()->find($id);
        $image = $product->images[0];
        if (!is_null($request->file('image'))) {
            $image->update([
                'src' => Helpers::upload('images/', $request->file('image')->guessExtension(), $request->file('image'))
            ]);
        }
        $product->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'quantite' => $request->quantite,
            //'image' => is_null($request->file('image'))?,
            'sale_price' => $request->sale_price,
            'categorie_id'=>$request->product_type_id,
            'price' => $request->price,
            'isvirtual' => $request->virtual == 'on' ? true : false,
            'paid_view' => $request->paidview,
            'free_view' => $request->freeview,
        ]);
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->get('item');
        $conge = Product::query()->find($id);
        $conge->delete();
        return response()->json(['data' => $conge, 'status' => true]);
    }
}
