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
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <dl class="row-md jh-entity-details">
                                    <dt>Client</dt>
                                    <dd>{{$order->user->name}} </dd>
                                    <dt>Total:</dt>
                                    <dd>{{$order->totalht}} FCFA </dd>
                                    <dt>Total Ttc</dt>
                                    <dd>{{$order->total}} FCFA</dd>
                                    <dt>Status</dt>
                                    <dd>{{$order->status}} </dd>
                                </dl>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Prix</th>
                                        <th>quantite</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lines as $line)
                                        <tr>
                                            <td></td>
                                            <td>{{$line->product->libelle}}</td>
                                            <td>{{$line->product->sale_price}}</td>
                                            <td>{{$line->quantite}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST">
                                {{csrf_field()}}
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Status</label>
                                        <select class="form-select">
                                            <option>PENDING</option>
                                            <option>VALIDATE</option>
                                            <option>ACTIVATED</option>
                                        </select>
                                    </div>
                                    <div class="row mb-3 text-center">
                                       <button class="btn btn-success rounded-pill" type="submit"> Changer le status </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


