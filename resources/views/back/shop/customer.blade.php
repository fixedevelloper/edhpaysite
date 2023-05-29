@extends('back.base')

@section('content')
    <div class="content-page">
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ajouter un lient</h4>
                            </div>
                            <div class="card-body">
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
                                        <button class="btn btn-success" type="submit"> Ajouter </button>
                                    </div>
                                </form>
                            </div>

                        </div>

            </div>
        </div>
    </div>

@endsection


