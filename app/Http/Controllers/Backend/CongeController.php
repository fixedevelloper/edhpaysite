<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Conge;
use App\Models\Soin;
use App\Models\User;
use Illuminate\Http\Request;

class CongeController extends Controller
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
            $agents = Conge::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('date_debut', 'like', "%{$value}%")
                        ->orWhere('date_fin', 'like', "%{$value}%")
                        ->orWhere('heure_debut', 'like', "%{$value}%")
                        ->orWhere('heure_fin', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Conge();
        }

        $agents = $agents->newQuery()->orderBy('date_debut','DESC')->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        $users = User::where("id", '>', 0)->estheticien()->get();
        return view('back.conge.index', compact('agents', 'search', 'users'));
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
            'date_debut' => 'required',
            'date_fin' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);
        $conge_ = Conge::query()->where('date_debut', '=', $request->date_debut)
            ->where('heure_debut', '=', $request->heure_debut)
            ->where('user_id', '=', $request->user_id)->first();
        if (isset($conge_)) {
            //  Toastr::warning(translate('This phone number is already taken'));
            return back();
        }
        $conge = new Conge();
        $conge->date_debut = $request->date_debut;
        $conge->date_fin = $request->date_fin;
        $conge->heure_debut = $request->heure_debut;
        $conge->heure_fin = $request->heure_fin;
        $conge->user_id = $request->user_id;
        $conge->save();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Soin $soin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $soin = Conge::find($id);
        $users = User::where("id", '>', 0)->estheticien()->get();
        return view('back.conge.update', compact('soin', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $conge = Conge::find($id);
        $conge->update([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
        ]);
        return redirect()->route('conge.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->get('item');
        $conge = Conge::query()->find($id);
        $conge->delete();
        return response()->json(['data' => $conge, 'status' => true]);
    }
}
