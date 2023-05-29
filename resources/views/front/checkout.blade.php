@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")
    <div class="container-fluid">
        @if(Session::get('products'))
        <div class="row px-xl-5">
            <div class="col-md-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">
                        Detail commande</span></h5>
                <div class="bg-light p-30 mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                        <tr>
                            <th>Produits</th>
                            <th>Prix</th>
                            <th>quantite</th>
                        </tr>
                        </thead>
                        <tbody class="align-middle">

                        @foreach($soins as $product)
                            <tr>
                                <td class="align-middle"> {{$product->libelle}}</td>
                                <td class="align-middle">{{$product->sale_price}}<i class=""></i>FCFA</td>
                                <td class="align-middle">{{$product->quantity}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">
                        Sommaire</span></h5>
                <div class="bg-light p-30 mb-3">
                    <dl class="row-md jh-entity-details">
                        <dt>Montant</dt>
                        <dd>{{$total}} FCFA</dd>
                        <dt>Montant total</dt>
                        <dd>{{$total}} FCFA</dd>
                    </dl>
                    <hr>
                </div>
                <div>
                    <h5 class="section-title position-relative text-uppercase mb-1"><span class="bg-secondary pr-3">
                        Paiement</span></h5>
                    <div  class="bg-light p-30 mb-5">
                        <form method="POST">
                            {{csrf_field()}}
                            <div class="form-check form-check-danger mb-2">
                                <input class="form-check-input" name="payement_method" value="caisse" type="radio" id="customradio17" checked>
                                <label class="form-check-label" for="customradio17"><img class="w-50" src="{{asset('multi/img/blue_paydunya.png')}}"></label>
                            </div>
                            <div class="form-check form-check-danger mb-2">
                                <input class="form-check-input" name="payement_method" value="paypal" type="radio" id="customradio17" >
                                <label class="form-check-label" for="customradio17"><img class="w-50" src="{{asset('multi/img/paypal.png')}}"></label>
                            </div>
                            <div class="form-check form-check-danger mb-2">
                                <input class="form-check-input" name="payement_method" value="bank_transfert" type="radio" id="customradio17" >
                                <label class="form-check-label" for="customradio17"><img class="w-50" src="{{asset('multi/img/logo-cinetpay.webp')}}"></label>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn col-md-12 mt-2 btn-outline-success rounded-pill">Je paie</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @else
            <div class="text-center px-xl-5">
                <p class="h5">Panier vide</p><br>
                <div class="">
                    <a href="{{route('home')}}" type="button" class="btn btn-outline-success">Acceuil</a>
                </div>
            </div>
        @endif
    </div>

@endsection

