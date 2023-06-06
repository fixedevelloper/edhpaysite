@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item">Boutique</a>
                    <span class="breadcrumb-item active">{{$shop->libelle}}</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")

    <!-- Shop Detail Start -->
    <div class="container pb-5">
        <div class="row pb-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <dl>
                            <dd>{{$shop->libelle}}</dd>
                            <dt>Adresse:</dt>
                            <dd>{{$shop->adresse}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
        <div class="row pb-3">
        @foreach($products as $product)
            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100 prod_size" src="{{asset('storage/images')}}/{{$product['images'][0]->src}}" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="{{route('addcart',['id'=>$product['id'],'quantity'=>1])}}"><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="{{route('detailproduct',['slug'=>$product['slug']])}}"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="{{route('detailproduct',['slug'=>$product['slug']])}}">{{$product['libelle']}}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{round($product->sale_price*$change,2)}} {{session()->get('currency')==="XAF"?'FCFA':session()->get('currency')}}</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>(99)</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
            </div>
        </div>
            <div class="col-12">
            <nav>
                <ul class="pagination justify-content-center">
                    {!! $products->links() !!}
                </ul>
            </nav>
        </div>
    </div>

    </div>
    <!-- Shop Detail End -->
@endsection
