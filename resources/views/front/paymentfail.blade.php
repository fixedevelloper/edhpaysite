@extends('front.base')

@section('content')

    @include("back._partials.errors-and-messages")
    <!-- Carousel Start -->
    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-6 card px-xl-5">
                <div class="card-img text-center">
                    <img class="img-fluid w-75" src="{{asset('multi/img/error_.png')}}">
                </div>
                <div class="text-center card-body">
                    <h2 class="text-danger">Echec de paiement!</h2>
                    <p class="text-black">Une erreur s'est produte lors de votre paiement</p>
                </div>

            </div>
        </div>

    </div>



@endsection
