@extends('front.base')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{route('home')}}">Home</a>
                    <span class="breadcrumb-item active">Services</span>
                </nav>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-img text-center">
                        <img class="img-fluid" src="{{asset('multi/img/wetransfer.png')}}">
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-img">
                        <img class="img-fluid" src="{{asset('logo.jpg')}}">
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-img">
                        <img class="img-fluid" src="{{asset('multi/img/filifilo.png')}}">
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
