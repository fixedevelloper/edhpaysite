@extends('back.base')

@section('content')
    <div class="content-page">
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                <div class="row mt-3">
                    <h4>Detail du vendeur(e) <span class="text-success">{{$shop->libelle}}</span></h4>
                </div>
                <div class="row mt-3">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Client</th>
                                        <th>Montant</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lines as $line)
                                    <tr>
                                        <td></td>
                                        <td>{{$line->created_at}}</td>
                                        <td>{{$line->order->user->name}}</td>
                                        <td>{{$line->product->libelle}}</td>
                                        <td>{{$line->order->total}} FCFA</td>
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
                                <dl>
                                    <dd>Total de ventes:</dd>
                                    <dt>{{$total_vente}} FCFA</dt>
                                    <dd>Solde courant:</dd>
                                    <dt>{{$current_solde}} FCFA</dt>
                                </dl>
                            </div>
                            <div class="card-footer">
                                <a class="btn btn-dark col-md-12">Retirer les fonds</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


