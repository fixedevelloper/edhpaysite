@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Commande</a>
                    <span class="breadcrumb-item active">Detail</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")
    <!-- Carousel Start -->
    <div class="container mb-3">
        <div class="row mt-3">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <dl class="row jh-entity-details">
                            <div class="col-md-6">
                                <dt>Date commande:</dt>
                                <dd>{{$order->created_at}}  </dd>
                                <dt>Total:</dt>
                                <dd>{{$order->totalht}}  </dd>
                            </div>
                            <div class="col-md-6">
                                <dt>Total Ttc</dt>
                                <dd>{{$order->total}} </dd>
                                <dt>Status</dt>
                                <dd>{{$order->status}} </dd>
                            </div>


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
                        <div>
                            {{$lines[0]->product->free_view}}
                        </div>
                        <div>
                            {{$lines[0]->product->paid_view}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
