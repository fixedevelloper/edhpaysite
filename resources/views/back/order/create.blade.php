@extends('back.base')

@section('content')
    <div class="content-page">
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h4>Effectuer une facturation</h4>
                    </div>
                    <div class="card-body">

                        <div class="row mt-1">
                            <div class=" col-md-12">
                                <label for="name" class="form-label">Client</label>
                                <div class="input-group">
                                    <select name="customer_id" id="customer_id" class="form-select">
                                        <option>Choisir le client</option>
                                        @foreach($customers as $item)
                                            <option value="{{$item->id}}">{{$item->name}} {{$item->lastname}}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{route('facturation.customer')}}"
                                       class="btn input-group-text btn-dark waves-effect waves-light" type="button">Ajouter
                                        client</a>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class=" col-md-6">
                                <label for="name" class="form-label">Produit</label>
                                <select name="customer_id" id="facture_prod_id" class="form-select">
                                    <option>Choisir le produit</option>
                                    @foreach($produits as $item)
                                        <option data-price="{{$item->price_sell}}" value="{{$item->id}}">{{$item->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <label for="name" class="form-label">Quantite</label>
                                <div class="input-group">
                                    <input class="form-control" name="lastname" type="number" id="quantity" required="">
                                    <a class="btn input-group-text btn-dark waves-effect waves-light"
                                       type="button"><i class="mdi mdi-plus-circle" id="add_line"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <table class="table table-bordered" id="table_product">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Prix</th>
                                    <th>Quantite</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="btn-save" class="btn btn-success waves-effect waves-light"> Enregistrer</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection


