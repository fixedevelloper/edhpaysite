<?php


namespace App\Http\Controllers\Front;


use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Image;
use App\Models\LineProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function seller_dashboard(Request $request){
        $user=Auth::user();
        if (is_null($user)){
            return redirect('/');
        }
        $shop=Shop::query()->where(['user_id'=>$user->id])->first();
        $products=Product::query()->latest()->where(['shop_id'=>$shop->id])->paginate(Helpers::pagination_limit());
        $lines=LineProduct::query()->leftJoin('orders','line_products.order_id','=','orders.id')
            ->leftJoin('products','line_products.product_id','=','products.id')
            ->where(['products.shop_id'=>$shop->id,'orders.status'=>Order::COMPLETED])->paginate(Helpers::pagination_limit());
        $total_vente=0.0;
        $downloads=[];
        foreach ($lines as $line){
            if ($line->product->isdownloable){
                $downloads[]=$line;
            }
            $total_vente+=$line->product->sale_price*$line->quantite;
        }
        $current_solde=$total_vente-$shop->retrait;
        return view('front.seller.dashboard', [
            'shop'=>$shop,
            'user'=>$user,
            'products'=>$products,
            'lines'=>$lines,
            'total_vente'=>$total_vente,
            'current_solde'=>$current_solde,

        ]);
    }
    public function seller_add_product(Request $request){
        $categories=Categorie::all();
        $user=Auth::user();
        $shop=Shop::query()->where(['user_id'=>$user->id])->first();
        if ($request->method()=="POST"){
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
            if (isset($agent)){
                //  Toastr::warning(translate('This phone number is already taken'));
                return back();
            }

            DB::transaction(function () use ($shop, $request, $email) {
                $user = new Product();
                $user->libelle = $request->libelle;
                $user->quantity = $request->quantite;
                $user->image = Helpers::upload('product/', 'png', $request->file('image'));
                $user->description = $request->description;
                $user->sale_price = $request->price_sell;
                $user->price = $request->price;
                $user->slug = Str::slug($request->libelle);
                $user->categorie_id = $request->product_type_id;
                $user->shop_id=$shop->id;
                $user->isvirtual = $request->virtual == 'on' ? true : false;
                $user->isdownloable = $request->isdownloable == 'on' ? true : false;
                $user->paid_view = $request->paidview;
                $user->free_view = $request->freeview;
              if ($request->isdownloable == 'on'){
                    $user->downloable_file = Helpers::upload('downloads/', $request->file('downloable_file')->guessExtension(), $request->file('downloable_file'));
                    $user->downloable_filename = $request->freeview;
                    $user->downloable_expired_date = $request->downloable_day;
                }
                $user->save();
                $image=new Image();
                $image->src=Helpers::upload('images/', $request->file('image')->guessExtension(), $request->file('image'));
                $image->name=$request->file('image')->getFilename();
                $image->alt=$request->file('image')->getFilename();
                $image->position=0;
                $image->save();
                $user->images()->attach($image->id);
            });
            return redirect()->route('seller_dashboard');
        }
        return view('front.seller.add_product', [
            'shop'=>$shop,
            'categories'=>$categories
        ]);
    }
    public function become_seller(Request $request)
    {
        $user=Auth::user();
        if ($user){
            if ($user->user_type==1){
                return redirect()->route('seller_dashboard');
            }
        }

        if ($request->method()=="POST"){
            $user=new User();
            $user->name=$request->get('name');
            $user->lastname=$request->get('name');
            $user->phone=$request->get('phone');
            $user->email=$request->get('email');
            $user->adresse=$request->get('adresse');
            $user->user_type=1;
            $user->password=bcrypt($request->get('password'));
            $user->save();
            $shop=new Shop();
            $shop->libelle=$request->get('name');
            $shop->phone=$request->get('phone');
            $shop->country=$request->get('country');
            $shop->adresse=$request->get('adresse');
            $shop->user_id=$user->id;
            $shop->save();
        }
        return view('front.seller.become_seller', [

        ]);
    }
    public function shop_detail($shop){
        $products=Product::query()->where(['shop_id'=>$shop])->latest()->paginate(Helpers::pagination_limit());
        return view('front.seller.detail_shop', [
            'products'=>$products,
            'change'=>helpers::setPrice(\session()->get('currency')),
            'shop'=>Shop::query()->find($shop)
        ]);
    }
}
