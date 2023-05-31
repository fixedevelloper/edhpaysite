@extends('back.base')

@section('content')
    <div class="content-page">
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                <div class="row mt-3">

                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{route('product.update',['id'=>$product->id])}}">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Libelle</label>
                                        <input class="form-control" value="{{$product->libelle}}" name="libelle" type="text" id="name" required="" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="price_" class="form-label">Prix</label>
                                        <input class="form-control" value="{{$product->price}}" min="0" name="price" type="number" id="price_" required="" placeholder="">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="sale_price" class="form-label">Prix de vente</label>
                                        <input value="{{$product->sale_price}}" class="form-control" min="0" name="sale_price" type="number" id="sale_price" required="" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Quantite</label>
                                        <input value="{{$product->quantity}}" class="form-control" min="0" name="quantite" type="number" id="name" required="" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Categorie</label>
                                        <select name="product_type_id" id="inputState" class="form-select">
                                            <option>Choisir la categorie</option>
                                            @foreach($categories as $item)
                                                @if($product['categorie_id']==$item->id)
                                                    <option selected value="{{$item->id}}">{{$item->libelle}}</option>
                                                @else
                                                <option {{ $product['categorie_id'] == $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->libelle}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="virtual" class="form-label">Produit virtuel?</label>
                                        <input id="virtual" @if($product['isvirtual'])checked @endif class="form-check" name="virtual" type="checkbox"
                                               placeholder="">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Image</label>
                                        <div class="text-center mt-1 mb-1">
                                            <img style="height: 100px;border: 1px solid; border-radius: 10px;" id="viewer"
                                                 src="{{asset('storage/product').'/'.$product['image']}}" alt="{{$product['image']}}"/>
                                        </div>
                                        <input class="form-control"
                                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" name="image" type="file" id="name">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea rows="4"  id="description" class="form-control" name="description" placeholder="">
                                            {{$product->description}}
                                        </textarea>
                                    </div>
                                </div>
                                <div id="contenu-virtual" class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="freeview" class="form-label">Contenu libre</label>
                                        <textarea id="freeview" rows="4" class="form-control" name="freeview" type="text"
                                                  placeholder="">
                                             {{$product->free_view}}
                                            </textarea>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="paidview" class="form-label">Contenu payant</label>
                                        <textarea id="paidview" rows="4" class="form-control" name="paidview" type="text"
                                                  placeholder="">
                                             {{$product->paid_view}}
                                            </textarea>
                                    </div>
                                </div>
                                <div class="mb-3 mt-5 text-center">
                                    <a class="btn btn-warning" type="button" href="{{route('product.index')}}"><i class="mdi mdi-arrow-left"></i> annuler </a>
                                    <button class="btn btn-success" type="submit"> Modifier </button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


