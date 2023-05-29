<?php


namespace App\Http\Controllers\Front;


use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function account(Request $request)
    {
        $user=Auth::user();
        $historiques=Order::query()->where('user_id','=',$user->id)
            ->latest()->paginate(Helpers::pagination_limit());
        return view('front.account', [
            'historiques'=>$historiques,
            'user'=>$user
        ]);
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
