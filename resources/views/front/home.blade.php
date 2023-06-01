@extends('front.base')

@section('content')

        @include("back._partials.errors-and-messages")
        <!-- Carousel Start -->
        <div class="container-fluid mb-3">
            <div class="row px-xl-5">

                <div class="col-lg-8">
                    <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#header-carousel" data-slide-to="1"></li>
                            <li data-target="#header-carousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @if(sizeof($soins)>0)
                                <div class="carousel-item position-relative active" style="height: 430px;">
                                    <img class="position-absolute w-100 h-100" src="{{asset('storage/images')}}/{{$soins[0]->images[0]->src}}" style="object-fit: cover;">
                                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                        <div class="p-3" style="max-width: 700px;">
                                            <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{$soins[0]->categorie->libelle}}</h1>
                                            <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{$soins[0]->libelle}}</p>
                                            <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"  href="{{route('cart',['id'=>$soins[0]->id])}}">Commander</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(sizeof($soins)>1)
                            <div class="carousel-item position-relative" style="height: 430px;">
                                <img class="position-absolute w-100 h-100" src="{{asset('storage/images')}}/{{$soins[1]->images[0]->src}}" style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{$soins[1]->categorie->libelle}}</h1>
                                        <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{$soins[1]->libelle}}</p>
                                        <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="{{route('cart',['id'=>$soins[1]->id])}}">Commander</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(sizeof($soins)>2)
                            <div class="carousel-item position-relative" style="height: 430px;">
                                <img class="position-absolute w-100 h-100" src="{{asset('storage/images')}}/{{$soins[2]->images[0]->src}}" style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{$soins[2]->categorie->libelle}}</h1>
                                        <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{$soins[2]->libelle}}</p>
                                        <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="{{route('cart',['id'=>$soins[2]->id])}}">Commander</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
               <div class="col-lg-4">
                    <div class="product-offer mb-30" style="height: 200px;">
                        <img class="img-fluid" src="{{asset('multi/img/offer1.jpeg')}}" alt="">
                        <div class="offer-text">
                            <h6 class="text-white text-uppercase">Reduction 20%</h6>
                            <h3 class="text-white mb-3">Offre speciale</h3>
                            <a href="" class="btn btn-primary">Commander</a>
                        </div>
                    </div>
                    <div class="product-offer mb-30" style="height: 200px;">
                        <img class="img-fluid" src="{{asset('multi/img/offer2.jpeg')}}" alt="">
                        <div class="offer-text">
                            <h6 class="text-white text-uppercase">Reduction 20%</h6>
                            <h3 class="text-white mb-3">Offre speciale</h3>
                            <a href="" class="btn btn-primary">Commander</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featured Start -->
        <div class="container-fluid pt-3">
            <div class="row px-xl-5 pb-3">
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                        <h1 class="fas fa-check text-primary m-0 mr-3"></h1>
                        <h5 class="font-weight-semi-bold m-0">Produit de qualité</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                        <h1 class="fas fa-check-square text-primary m-0 mr-2"></h1>
                        <h5 class="font-weight-semi-bold m-0">Service de qualité</h5>
                    </div>
                </div>
               <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                        <h1 class="fas fa-shipping-fast text-primary m-0 mr-3"></h1>
                        <h5 class="font-weight-semi-bold m-0">SAV</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                        <h1 class="fas fa-phone-volume text-primary m-0 mr-3"></h1>
                        <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Categories Start -->
        <div class="container-fluid pt-5">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
            <div class="row px-xl-5 pb-3">
                @foreach($categories as $categorie)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid" src="{{asset('storage/images')}}/{{$categorie->image->src}}" alt="category image">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6>{{$categorie->libelle}}</h6>
                                <small class="text-body">100 Products</small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Categories End -->
        <!-- Products Start -->
        <div class="container-fluid pt-5 pb-3">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
            <div class="row px-xl-5">
                @foreach($features as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 prod_size" src="{{asset('storage/images')}}/{{$item->images[0]->src}}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{route('addcart',['id'=>$item->id,'quantity'=>1])}}"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="{{route('detailproduct',['slug'=>$item->slug])}}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{route('detailproduct',['slug'=>$item->slug])}}">{{$item->libelle}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{round($item->sale_price*$change,2)}} {{session()->get('currency')==="XAF"?'FCFA':session()->get('currency')}}</h5>
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
        <!-- Products End -->


        <!-- Offer Start -->
        <div class="container-fluid pt-5 pb-3">
            <div class="row px-xl-5">
                <div class="col-md-6">
                    <div class="product-offer mb-30" style="height: 300px;">
                        <img class="img-fluid" src="{{asset('multi/img/offer2.jpeg')}}" alt="">
                        <div class="offer-text">
                            <h6 class="text-white text-uppercase">Reduction 20%</h6>
                            <h3 class="text-white mb-3">Offre special</h3>
                            <a href="" class="btn btn-primary">Visitez</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-offer mb-30" style="height: 300px;">
                        <img class="img-fluid" src="{{asset('multi/img/offer1.jpeg')}}" alt="">
                        <div class="offer-text">
                            <h6 class="text-white text-uppercase">Save 20%</h6>
                            <h3 class="text-white mb-3">Offre speciale</h3>
                            <a href="" class="btn btn-primary">Visitez</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Offer End -->


        <!-- Products Start -->
        <div class="container-fluid pt-5 pb-3">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Recent Products</span></h2>
            <div class="row px-xl-5">
                @foreach($features as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 prod_size" src="{{asset('storage/images')}}/{{$item->images[0]->src}}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{route('addcart',['id'=>$item->id,'quantity'=>1])}}"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="{{route('detailproduct',['slug'=>$item->slug])}}"><i class="fa fa-search"></i></a>

                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{route('detailproduct',['slug'=>$item->slug])}}">{{$item->libelle}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{$item->sale_price}} FCFA</h5>
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
        <!-- Products End -->
        <!-- Vendor Start -->
        <div class="container-fluid py-5">
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel vendor-carousel">
                        <div class="bg-light p-4">
                            <img src="img/vendor-1.jpg" alt="">
                        </div>
                        <div class="bg-light p-4">
                            <img src="img/vendor-2.jpg" alt="">
                        </div>
                        <div class="bg-light p-4">
                            <img src="img/vendor-3.jpg" alt="">
                        </div>
                        <div class="bg-light p-4">
                            <img src="img/vendor-4.jpg" alt="">
                        </div>
                        <div class="bg-light p-4">
                            <img src="img/vendor-5.jpg" alt="">
                        </div>
                        <div class="bg-light p-4">
                            <img src="img/vendor-6.jpg" alt="">
                        </div>
                        <div class="bg-light p-4">
                            <img src="img/vendor-7.jpg" alt="">
                        </div>
                        <div class="bg-light p-4">
                            <img src="img/vendor-8.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vendor End -->


@endsection
