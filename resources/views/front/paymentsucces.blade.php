@extends('front.base')

@section('content')

    @include("back._partials.errors-and-messages")
    <!-- Carousel Start -->
    <div class="containermb-3">
        <div class="row justify-content-center">
            <div class="col-md-6 card px-xl-5">
                <div class="card-img text-center">
                    <img class="img-fluid w-75" src="{{asset('multi/img/success_icon.png')}}">
                </div>
                <div class="text-center card-body">
                    <h2 class="text-success">Paiement successful!</h2>
                    <p class="text-black">Votre paiement a ete effectué avec success</p>
                </div>

            </div>
        </div>
    </div>



@endsection

