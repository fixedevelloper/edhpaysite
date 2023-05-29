<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Image;
use  Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\Slugger\slug;

class CategoryController extends Controller
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
            $agents = Categorie::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('libelle', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $agents = new Categorie();
        }

        $agents = $agents->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('back.product_type.index', compact('agents', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.product_type.create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
        ]);

        $libelle = $request->libelle;
        $agent = Categorie::where(['libelle' => $libelle])->first();
        if (isset($agent)){
            //  Toastr::warning(translate('This phone number is already taken'));
            return back();
        }
        logger($request->file('image')->guessExtension());
        DB::transaction(function () use ($request, $libelle) {
            $image=new Image();
            $image->src=Helpers::upload('images/', $request->file('image')->guessExtension(), $request->file('image'));
            $image->name=$request->file('image')->getFilename();
            $image->alt=$request->file('image')->getFilename();
            $image->position=0;
            $image->save();
            $user = new Categorie();
            $user->libelle = $request->libelle;
            $user->slug = Str::slug($request->libelle);
            $user->description = $request->description;
            $user->display_name = $request->display_name;
            $user->image_id=$image->id;
            $user->parent =0;
                $user->save();
        });

        // Toastr::success(translate('Agent Added Successfully!'));
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product_type = Categorie::find($id);
        return view('back.product_type.update', compact('product_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $conge = Categorie::find($id);
        $conge->update([
            'libelle' => $request->libelle,
        ]);
        return redirect()->route('product_type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->get('item');
        $conge = Categorie::query()->find($id);
        $conge->delete();
        return response()->json(['data' => $conge, 'status' => true]);
    }
}
