<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstheticienController extends Controller
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
            $agents = new User();
        }

        $agents = $agents->estheticien()->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.estheticien.index', compact('agents', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.estheticien.create', []);
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
            'email' => 'required|unique:users|min:4|max:100',
            'phone' => 'required|unique:users|min:8|max:100',
            'adresse' => 'required',
            'password' => 'required|min:4|max:14',
        ],[
            'password.min' => 'Password must contain 4 characters',
            'password.max' => 'Password must contain 14 characters',
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
            $user->role = 'ROLE_AGENT';
         //   $user->occupation = $request->occupation;
            $user->password = bcrypt($request->password);
            $user->user_type = 1;    //['Admin'=>0, 'Agent'=>1, 'Customer'=>2]
            $user->save();
        });

       // Toastr::success(translate('Agent Added Successfully!'));
        return back();
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
        $user = User::find($id);
        return view('back.estheticien.update', compact('user'));
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
        return redirect()->route('estheticien.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->get('item');
        $customer = User::query()->find($id);
        $bool=  $customer->update([
            'activate'=>false
        ]);
/*        $conge = User::query()->find($id);
        $conge->delete();*/
        return response()->json(['data' => $bool, 'status' => true]);
    }
}
