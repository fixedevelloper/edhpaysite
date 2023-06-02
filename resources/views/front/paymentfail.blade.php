@extends('front.base')

@section('content')

    @include("back._partials.errors-and-messages")
    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="card px-xl-5">
            <div class="card-body">
                <h5>Echec!</h5>
                <p>Une erreur s'est produte lors de votre paiement</p>
            </div>

        </div>
    </div>



@endsection
