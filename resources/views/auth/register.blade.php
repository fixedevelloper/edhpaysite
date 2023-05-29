@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Reservation</a>
                    <span class="breadcrumb-item active">Inscription</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <div class="container-fluid">
        <div class="row px-xl-5">

                <div class="col-md-8">
                    <div class="text-center">
                        <a href="/">
                          <img src="{{asset('logo.jpg')}}" alt="" height="100" class="mx-auto">
                        </a>
                        {{--  <p class="text-muted mt-2 mb-4">{{env('APP_NAME')}}</p>--}}

                    </div>
                    @include("back._partials.errors-and-messages")
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Inscription</h4>
                            </div>

                            <form method="POST">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nom</label>
                                        <input class="form-control" name="firstname" type="text" id="name" required="" placeholder="Entrer votre nom">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Prenom</label>
                                        <input class="form-control" name="lastname" type="text" required="" id="lastname" placeholder="Entrer votre prenom">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="emailaddress" class="form-label">Email address</label>
                                        <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Entrer votre email">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control" name="password" type="password" required="" id="password" placeholder="Entrer votre password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Telephone</label>
                                        <input class="form-control" name="phone" type="text" id="name" required="" placeholder="Entrer votre Telephone">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Adresse</label>
                                        <input class="form-control" name="adresse" type="text" id="name" required="" placeholder="Entrer votre Adresse">
                                    </div>
                                </div>

                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-success" type="submit"> S'inscrire </button>
                                </div>
                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="#" class="text-muted ms-1"><i class="fa fa-lock me-1"></i>Vous avez oublié votre mot de passe?</a></p>
                            <p class="text-muted">Avez vous deja un compte? <a href="{{route('logincustomer')}}" class="text-dark ms-1"><b>Se connecter</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <div class="col-md-4 my-5 pt-lg-5">
                    <img src="{{asset('multi/img/offer1.jpeg')}}" alt="image" width="400" height="300" class="mx-auto">
                </div>
            </div>
    </div>
@endsection

