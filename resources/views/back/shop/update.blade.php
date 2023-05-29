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
                            <div class="card-body">


                            <form method="POST" action="{{route('facturation.update',['id'=>$facture->id])}}">

                                    {{csrf_field()}}
                                    <div class="row mt-1">
                                        <div class=" col-md-6">
                                            <label for="name" class="form-label">Client</label>

                                                <select name="customer_id" id="inputState" class="form-select">
                                                    <option>Choisir le client</option>

                                                    @foreach($customers as $item)
                                                        @if($facture['customer']->id == $item->id)
                                                        <option selected value="{{$item->id}}">{{$item->name}}-{{$item->lastname}}</option>
                                                        @else
                                                            <option value="{{$item->id}}">{{$item->name}} {{$item->lastname}}</option>
                                                        @endif
                                                            @endforeach
                                                </select>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Estheticiene</label>
                                            <select name="user_id" id="inputState" class="form-select">
                                                <option>Choisir l'estheticiene</option>
                                                @foreach($estheticiens as $item)
                                                    <option {{ $facture['user']->id == $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}} {{$item->lastname}}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Soin</label>
                                            <select name="soin_id" id="inputSoin" class="form-select">
                                                <option>Choisir le soin</option>
                                                @foreach($soins as $item)
                                                    <option  {{ $facture['soin']->id == $item->id ? 'selected' : '' }} data-duree="{{$item->duree}}" data-price="{{$item->price}}" value="{{$item->id}}">{{$item->libelle}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Prix</label>
                                            <input class="form-control"  name="name" type="text" id="price" disabled placeholder="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Duree</label>
                                            <input class="form-control"  name="name" type="text" id="duree" disabled placeholder="">
                                        </div>
                                    </div>
                                    <div class=" p-3 mb-3 text-center">
                                        <a class="btn btn-warning" type="button" href="{{route('facture.index')}}"><i class="mdi mdi-arrow-left"></i> annuler </a>
                                        <button class="btn btn-success" type="submit"> Modifier </button>
                                    </div>
                            </form>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


