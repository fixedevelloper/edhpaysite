<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                <a class="text-body mr-3" href="">Apropos</a>
                <a class="text-body mr-3" href="{{route('contact')}}">Contact</a>
                <a class="text-body mr-3" href="">Aide</a>
                <a class="text-body mr-3" href="">FAQs</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="btn-group mx-2">
                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">{{session()->get('currency')}}</button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{route('currencychange',['currency'=>'EUR'])}}" class="dropdown-item" type="button">EUR</a>
                    <a href="{{route('currencychange',['currency'=>'USD'])}}" class="dropdown-item" type="button">USD</a>
                    <a href="{{route('currencychange',['currency'=>'XAF'])}}" class="dropdown-item" type="button">XAF</a>
                    <a href="{{route('currencychange',['currency'=>'XOF'])}}" class="dropdown-item" type="button">XOF</a>
                    <a href="{{route('currencychange',['currency'=>'GBP'])}}" class="dropdown-item" type="button">GBP</a>
                    <a href="{{route('currencychange',['currency'=>'CAD'])}}" class="dropdown-item" type="button">CAD</a>
                </div>
            </div>
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    @if(auth()->check() && auth()->user()->user_type == 2)
                        <a href="{{route('account')}}" type="button" class="btn btn-sm btn-light">Mon compte</a>
                    @else
                        <a href="{{route('logincustomer')}}" class="btn btn-sm btn-outline-success" type="button">Se connecter</a>
                        <a href="{{route('register')}}" class="btn btn-sm btn-outline-primary" type="button">S'inscrire</a>
                    @endif
                </div>
            </div>

            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
                <a href="{{route('checkout')}}" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    @if(session('soin_id'))
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">1</span>
                    @else
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="{{route('home')}}" class="text-decoration-none">
                <img src="{{ asset('logo.jpg') }}" height="100">
                {{--<span class="h1 text-uppercase text-primary bg-dark px-2">STYL</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">ISTE</span>--}}
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
           <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Recherche des produits">
                    <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Service client</p>
            <h5 class="m-0">+242 06 444 9019</h5>
        </div>
    </div>
</div>
<!-- Topbar End -->
<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    @foreach(\App\Models\Categorie::all() as $categorie)
                    <a href="{{route('categorieproducts',['slug'=>$categorie->slug])}}" class="nav-item nav-link">{{$categorie->libelle}}</a>
                    @endforeach
                </div>
              {{--  <div class="navbar-nav w-100">
                    <div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>
                    <a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>
                </div>--}}
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="{{route('home')}}" class="text-decoration-none d-block d-lg-none">
                    <img src="{{ asset('logo.jpeg') }}">
               </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{route('home')}}" class="nav-item nav-link {{request()->routeIs('home')?'active':''}}">Accueil</a>
                        <a href="{{route('services')}}" class="nav-item nav-link {{request()->routeIs('services')?'active':''}}">Services</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Boutiques <i class="fa fa-angle-down mt-1"></i></a>
                            <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                @foreach(\App\Models\Shop::all() as $shop)
                                    <a href="{{route('shop_detail',['id'=>$shop->id])}}" class="dropdown-item">{{$shop->libelle}}</a>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{route('products')}}" class="nav-item nav-link {{request()->routeIs('products')?'active':''}}">Nos produits</a>
                        <a href="{{route('become_seller')}}" class="nav-item nav-link {{request()->routeIs('become_seller')?'active':''}}">Devenir vendeur</a>
                        <a href="{{route('contact')}}" class="nav-item nav-link {{request()->routeIs('contact')?'active':''}}">Contact</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="{{route('testpayement')}}" class="btn px-0" target="_blank">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                        <a href="{{route('cart')}}" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            @if(!is_null(session('products')))
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">{{sizeof(session('products'))}}</span>
                            @else
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            @endif
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
