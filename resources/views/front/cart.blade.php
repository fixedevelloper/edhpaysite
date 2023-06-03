@extends('front.base')

@section('content')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{route('home')}}">Accueil</a>
                    <span class="breadcrumb-item active">Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    @include("back._partials.errors-and-messages")

    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Prix</th>
                        <th>quantite</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">

                    @foreach($soins as $product)
                    <tr>
                        <td class="align-middle"><img src="{{asset('storage/images')}}/{{$product['item']->images[0]->src}}" alt="" style="width: 50px;"> {{$product['item']->libelle}}</td>
                        <td class="align-middle"></i>{{round($product['item']->sale_price * $change,2)}}<i class="">{{session()->get('currency')==="XAF"?'FCFA':session()->get('currency')}}</td>
                        <td class="align-middle">{{$product['quantity']}}</td>
                        <td class="align-middle"><a href="{{route('removesession',['id'=>$product['item']->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <a href="{{route('products')}}" class="h6 btn btn-dark mt-2 pull-right">Ajouter un product</a>
            </div>
            <div class="col-lg-4">
                {{--  <form class="mb-30" action="">
                     <div class="input-group">
                    -   <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                         <div class="input-group-append">
                             <button class="btn btn-primary">Apply Coupon</button>
                         </div>
                    </div>
                </form>--}}
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Sub-Total</h6>
                            <h6>{{round($totalht * $change,2)}}<i class=""></i>{{session()->get('currency')==="XAF"?'FCFA':session()->get('currency')}}</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="font-weight-medium">Tva</h6>
                            <h6 class="font-weight-medium">{{round($totaltva * $change,2)}}<i class=""></i>{{session()->get('currency')==="XAF"?'FCFA':session()->get('currency')}}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Reduction</h6>
                            <h6 class="font-weight-medium">0.0<i class=""></i>{{session()->get('currency')==="XAF"?'FCFA':session()->get('currency')}}</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>{{round($total * $change,2)}}<i class=""></i>{{session()->get('currency')==="XAF"?'FCFA':session()->get('currency')}}</h5>
                        </div>
                        <a href="{{route('checkout')}}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Continue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->



@endsection
