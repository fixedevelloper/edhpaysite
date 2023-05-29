@extends('back.base')

@section('content')
    <div class="content-page">
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                <div class="row mt-3">

                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <form method="POST" action="{{route('customer.update',['id'=>$user->id])}}">
                                {{csrf_field()}}
                                <div class="row p-3">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Nom</label>
                                        <input class="form-control" value="{{$user->name}}" name="name" type="text" id="name" required="" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Prenom</label>
                                        <input class="form-control" value="{{$user->lastname}}" name="lastname" type="text" id="name" required="" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Email</label>
                                        <input class="form-control" value="{{$user->email}}" name="email" type="email" id="name" required="" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Téléphone</label>
                                        <input class="form-control" value="{{$user->phone}}" name="phone" type="text" id="name" required="" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Adresse</label>
                                        <input class="form-control" value="{{$user->adresse}}" name="adresse" type="text" id="name" required="" placeholder="Enter your name">
                                    </div>

                                </div>
                                <div class="mb-3 text-center">
                                    <a class="btn btn-warning" type="button" href="{{route('customer.index')}}"><i class="mdi mdi-arrow-left"></i> annuler </a>
                                    <button class="btn btn-success" type="submit"> Modifier </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


