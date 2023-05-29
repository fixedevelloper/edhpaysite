@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <span class="breadcrumb-item active">Devenir vendeur</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")
    <div class="container">
        <h4 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Creer votre compte vendeur</span></h4>
        <div class="card">
            <div class="card-body">
                <form name="" method="POST" id="contactForm" novalidate="novalidate">
                    {{csrf_field()}}
                    <div class="row px-xl-5">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Nom de la boutique </label>
                                <input class="form-control" name="name" type="text" id="emailaddress" required="" placeholder="Nom de la boutique">
                            </div>
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Adresse mail</label>
                                <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Votre email">
                            </div>
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Téléphone </label>
                                <input class="form-control" name="phone" type="text" id="emailaddress" required="" placeholder="Telephone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Adresse de la boutique </label>
                                <input class="form-control" name="adresse" type="text" id="emailaddress" required="" placeholder="Adresse de la boutique">
                            </div>
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">pays </label>
                                <input class="form-control" name="country" type="text" id="emailaddress" required="" placeholder="Pays">
                            </div>
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Mot de passe </label>
                                <input class="form-control" name="password" type="password" id="emailaddress" required="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 px-lg-5">
                        <label for="emailaddress" class="form-label">Image de la boutique </label>
                        <input class="form-control" name="image" type="file" id="emailaddress" required="" placeholder="Image">
                    </div>
                    <div class="mb-3 text-center rounded-pill">
                        <button class="btn btn-primary" type="submit"> valider </button>
                    </div>
                </form>

            </div>
        </div>


    </div>

@endsection
