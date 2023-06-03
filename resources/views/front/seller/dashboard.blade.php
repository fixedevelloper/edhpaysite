@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Boutique</a>
                    <span class="breadcrumb-item active">{{$shop->libelle}}</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")
    <div class="container-fluid">
        <h5 class="section-title position-relative text-uppercase  mx-xl-5 mb-4"><span class="bg-secondary pr-3">
                        Ma Boutique</span></h5>
        <div class="row px-xl-5">
            <div class="col-sm-3">
                <div class="bg-light p-30 mb-5">

                        <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active show mb-1" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                               aria-selected="true">
                                Dashboard</a>
                            <a class="nav-link mb-1" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages"
                               aria-selected="false">
                                Mes produits</a>
                            <a class="nav-link mb-1" id="v-pills-sellers-tab" data-toggle="pill" href="#v-pills-sellers" role="tab" aria-controls="v-pills-messages"
                               aria-selected="false">
                                Mes ventes</a>
                            <a class="nav-link mb-1" id="retrait-fond-tab" data-toggle="pill" href="#retrait-fond" role="tab" aria-controls="v-pills-profile"
                               aria-selected="false">
                                Transfert fonds</a>
                            <a class="nav-link mb-1" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                               aria-selected="false">
                                Profile</a>
                            <a class="nav-link mb-1" id="v-pills-settings-tab" href="{{route('destroy')}}" role="tab" aria-controls="v-pills-settings"
                               aria-selected="false">
                                Deconnecté</a>
                        </div>
                    </div> <!-- end col-->

                </div>
           <div class="col-sm-9">
            <div class="bg-light p-30 mb-5">
            <div class="tab-content pt-0">
                <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="text-center mt-3">
                        <img src="{{ asset('logo.jpg') }}" class="w-75">
                    </div>
                </div>
                <div class="tab-pane fade" id="retrait-fond" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="mt-3">
                        <form method="POST" action="{{route('changeimage')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Telephone</label>
                                    <input class="form-control" name="t_phone"
                                           type="text" id="name" required=""
                                           placeholder="+237675085296">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Montant</label>
                                    <div class="input-group">
                                        <input class="form-control" name="t_amount"
                                               type="number" id="name" required=""
                                               placeholder="0">
                                        <a class="btn input-group-text btn-primary waves-effect waves-light" type="button">Envonyer</a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="bg-picture">
                                        <div class="d-flex align-items-top">
                                            <img src="{{asset('storage/uploads/'.auth()->user()->photo)}}"
                                                 class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3"
                                                 alt="profile-image">
                                        </div>
                                        <form method="POST" action="{{route('changeimage')}}" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <div class="mt-3 d-grid text-center">
                                                <input required name="photo" type="file" placeholder="Changer image">
                                            </div>
                                            <div class="mt-3 d-grid text-center">
                                                <button class="btn btn-success" type="submit"> Changer image </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#profile1" data-toggle="tab" aria-expanded="true"
                                               class="nav-link active">
                                                Profile
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#messages1" data-toggle="tab" aria-expanded="false"
                                               class="nav-link">
                                                Changer mot de passe
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="profile1">
                                            <form method="POST" action="{{route('app.profil')}}">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="name" class="form-label">Nom</label>
                                                        <input value="{{$user->name}}" class="form-control" name="firstname"
                                                               type="text" id="name" required=""
                                                               placeholder="Enter your name">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="lastname" class="form-label">Prenom</label>
                                                        <input value="{{$user->lastname}}" class="form-control"
                                                               name="lastname" type="text" required="" id="lastname"
                                                               placeholder="Enter your lastName">
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-8 mb-3">
                                                        <label for="emailaddress" class="form-label">Email address</label>
                                                        <input value="{{$user->email}}" class="form-control" name="email"
                                                               type="email" id="emailaddress" required=""
                                                               placeholder="Enter your email">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="phone" class="form-label">Telephone</label>
                                                        <input value="{{$user->phone}}" class="form-control" name="phone"
                                                               type="text" id="name" required=""
                                                               placeholder="Enter your Telephone">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="phone" class="form-label">Adresse</label>
                                                        <input value="{{$user->adresse}}" class="form-control"
                                                               name="adresse" type="text" id="name" required=""
                                                               placeholder="Enter your Adresse">
                                                    </div>
                                                </div>
                                                <div class="mb-3 d-grid text-center">
                                                    <button class="btn btn-success" type="submit"> Modifier</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="messages1">
                                            <form method="POST" action="{{route('changepassword')}}">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="oldpassword" class="form-label">Ancien mot de
                                                            passe</label>
                                                        <input class="form-control" name="oldpassword" type="password"
                                                               id="oldpassword" required="" placeholder="">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="password" class="form-label">Nouveau mot de
                                                            passe</label>
                                                        <input class="form-control" name="password" type="password"
                                                               required="" id="password" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="mb-3 d-grid text-center">
                                                    <button class="btn btn-outline-dark" type="submit"> Changer le mot de
                                                        passe
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="row float-right pr-3">
                        <a class="btn btn-dark" href="{{route('seller_add_product')}}">Ajouter</a>
                    </div>
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#N°</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Prix</th>
                                <th>Prix de vente</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($products as $key=>$agent)
                                <tr>
                                    <td>{{$products->firstitem()+$key}}</td>
                                    <td>
                                        <img class="rounded-circle" height="60px" width="60px" style="cursor: pointer"
                                             onclick="location.href='{{route('product.edit',[$agent['id']])}}'"

                                             src="{{asset('storage/images')}}/{{$agent['images'][0]->src}}">
                                    </td>
                                    <td>
                                        {{$agent['libelle']}}
                                    </td>

                                    <td>
                                        {{$agent['price']}}FCFA
                                    </td>

                                    <td>
                                        {{$agent['sale_price']}}FCFA
                                    </td>
                                    <td></td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                </div>
                <div class="tab-pane fade" id="v-pills-sellers" role="tabpanel" aria-labelledby="v-pills-messages-tab">

                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#N°</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="set-rows">
                            @foreach($lines as $key=>$agent)
                                <tr>
                                    <td>{{$products->firstitem()+$key}}</td>
                                    <td>
                                        {{$agent['created_at']}}
                                    </td>
                                    <td>
                                        {{$agent['order']->user->name}}
                                    </td>
                                    <td>
                                        {{$agent['product']->libelle}}
                                    </td>

                                    <td>
                                        {{$agent['product']->sale_price*$agent['quantite']}} FCFA
                                    </td>
                                    <td>
                                        {{$agent['order']->status}}
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            </div>
           </div>
        </div> <!-- end col-->

    </div>

@endsection
