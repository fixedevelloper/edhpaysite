@extends('back.base')

@section('content')
    <div class="content-page">
        <div class="content">
        @include("back._partials.errors-and-messages")
        <!-- Start Content-->
            <div class="container-fluid">
                <div class="text-center mt-3">
                    <img src="{{ asset('logo.jpg') }}" height="300">
                </div>

            </div>
        </div>
    </div>

@endsection

