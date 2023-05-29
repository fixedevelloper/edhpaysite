@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Reservation</a>
                    <span class="breadcrumb-item active">Connexion</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <div class="container-fluid">
        <div class="row px-xl-5">

                <div class="col-md-6 mt-lg-5 p-lg-5">
                    <img src="{{asset('multi/img/offer1.jpeg')}}" alt="image" height="350" class="mx-auto">
                </div>
                <div class="col-md-6">
                    <div class="text-center mb-1">
                        <a href="/">
                         <img src="{{asset('logo.jpg')}}" alt="" height="100" class="mx-auto">
                        </a>
                              </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Connexion</h4>
                            </div>

                            <form method="POST" action="{{ route('loginstorecustomer') }}" >
                                {{csrf_field()}}
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Adresse email</label>
                                    <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="votre email">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input class="form-control" name="password" type="password" required="" id="password" placeholder="votre mot de passe">
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Se souvenir de moi</label>
                                    </div>
                                </div>

                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary" type="submit"> Se connecter </button>
                                </div>
                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="{{route('reset_password')}}" class="text-muted ms-1"><i class="fa fa-lock me-1"></i>Mot de passe oublié?</a></p>
                            <p class="text-muted">Vous n'avez pas encore de compte? <a href="{{route('register')}}" class="text-dark ms-1"><b>S'inscrire</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>

    </div>

@endsection
