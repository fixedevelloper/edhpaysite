<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FournisseurController extends Controller
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
            $agents = Fournisseur::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('libelle', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Fournisseur();
        }

        $agents = $agents->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.fournisseur.index', compact('agents', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $name = $request->libelle;
        $agent = Fournisseur::where(['name' => $name])->first();
        if (isset($agent)){
            //  Toastr::warning(translate('This phone number is already taken'));
            return back();
        }

        DB::transaction(function () use ($request, $name) {
            $user = new Fournisseur();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
        });

        // Toastr::success(translate('Agent Added Successfully!'));
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Fournisseur::find($id);
        return view('back.fournisseur.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $conge = Fournisseur::find($id);
        $conge->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return redirect()->route('fournisseur.index');
    }

    /**
     * Remove the specified resource from storage.
     */

        public function destroy(Request $request)
    {
        $id=$request->get('item');
       $fournisseur = Fournisseur::query()->find($id);
        $fournisseur->delete();
       /* $bool=  $fournisseur->update([
            'activate'=>false
        ]);*/
        return response()->json(['data' => $fournisseur, 'status' => true]);
    }
}
