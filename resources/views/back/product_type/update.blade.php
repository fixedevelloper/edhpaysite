@extends('back.base')

@section('content')
    <div class="content-page">
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                <div class="row mt-3">

                </div>
                <div class="row mt-3 justify-content-between">
                    <div class="col-8">
                        <div class="card">
                            <form method="POST" action="{{route('product_type.update',['id'=>$product_type->id])}}">
                                {{csrf_field()}}
                                <div class="row p-3">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Libelle</label>
                                        <input class="form-control" value="{{$product_type->libelle}}" name="libelle" type="text" id="name" required="" placeholder="Enter your name">
                                    </div>
                                </div>
                                <div class="mb-3 text-center">
                                    <a class="btn btn-warning" type="button" href="{{route('product_type.index')}}"><i class="mdi mdi-arrow-left"></i> annuler </a>
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


