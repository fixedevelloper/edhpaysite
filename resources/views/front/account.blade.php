@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{route('home')}}">Accueil</a>
                    <span class="breadcrumb-item active">Mon compte</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")
    <div class="container-fluid">
        <h5 class="section-title position-relative text-uppercase mb-3 mx-xl-5 "><span class="bg-secondary pr-3">
                        Mon compte</span></h5>
        <div class="row px-xl-5">
            <div class="col-sm-3">
                <div class="bg-light p-30 mb-5">

                        <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active show mb-1" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                               aria-selected="true">
                                Dashboard</a>
                            <a class="nav-link mb-1" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages"
                               aria-selected="false">
                                Commandes</a>
                            <a class="nav-link mb-1" id="download-tab" data-toggle="pill" href="#download" role="tab" aria-controls="v-pills-messages"
                               aria-selected="false">
                                Téléchargements</a>
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
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#N°</th>
                                <th>Date</th>
                                <th>Prix</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($historiques as $key=>$agent)
                                <tr>
                                    <td>{{$historiques->firstitem()+$key}}</td>
                                    <td>
                                        {{$agent['created_at']}}
                                    </td>

                                    <td>
                                        {{$agent['total']}}
                                    </td>

                                    <td>
                                        {{$agent['status']}}
                                    </td>
                                    <td>
                                        @if($agent['status']==\App\Models\Order::COMPLETED)
                                            <a class="btn btn-success btn-sm rounded-pill" href="{{route('detailorder',['order_key'=>$agent['order_key']])}}">Afficher</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="tab-pane fade" id="download" role="tabpanel" aria-labelledby="download-tab">
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Téléchargement</th>
                                <th>Date d'expiration</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($downloads as $download)
                                <tr>
                                    <td>
                                        {{$download['product']->libelle}}
                                    </td>

                                    <td>
                                       5
                                    </td>

                                    <td>
                                        {{$download['product']->downloable_expired_date}}
                                    </td>
                                    <td>
                                        @if($download['status']==\App\Models\Order::COMPLETED)
                                            <a class="btn btn-primary btn-sm rounded-pill" href="{{route('downloadfile',['id'=>$download['product']->id])}}">Telecharger</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                </div>
            </div>
            </div>
           </div>
        </div> <!-- end col-->

    </div>
 {{--   <div class="container-xxl py-3">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Mon compte</h4>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active show mb-1" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                       aria-selected="true">
                                        Dashboard</a>
                                    <a class="nav-link mb-1" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                       aria-selected="false">
                                        Profile</a>
                                    <a class="nav-link mb-1" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages"
                                       aria-selected="false">
                                        Historiques</a>
                                    <a class="nav-link mb-1" id="v-pills-settings-tab" href="{{route('destroy')}}" role="tab" aria-controls="v-pills-settings"
                                       aria-selected="false">
                                        Deconnecté</a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
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
                                                                <a href="#profile1" data-bs-toggle="tab" aria-expanded="true"
                                                                   class="nav-link active">
                                                                    Profile
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#messages1" data-bs-toggle="tab" aria-expanded="false"
                                                                   class="nav-link">
                                                                    Changer mot de passe
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane show active" id="profile1">
                                                                <form method="POST">
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
                                        <div class="table-responsive datatable-custom">
                                            <table
                                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>#N°</th>
                                                    <th style="width: 30%">Estheticiene</th>
                                                    <th>Date</th>
                                                    <th>heure</th>
                                                    <th>Soin</th>
                                                    <th>Prix</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>

                                                <tbody id="set-rows">
                                                @foreach($historiques as $key=>$agent)
                                                    <tr>
                                                        <td>{{$historiques->firstitem()+$key}}</td>

                                                        <td>
                                                            {{$agent['user']->name}}
                                                        </td>
                                                        <td>
                                                            {{$agent['date_reservation']}}
                                                        </td>
                                                        <td>
                                                            {{$agent['heure_reservation']}}
                                                        </td>

                                                        <td>
                                                            {{$agent['soin']->libelle}}
                                                        </td>
                                                        <td>
                                                            {{$agent['soin']->price}} <span class="mdi mdi-currency-eur"></span>
                                                        </td>
                                                        <td>
                                                            {{$agent['status']}}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                   </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end card-->
        </div>
        </div>

    </div>--}}

@endsection
