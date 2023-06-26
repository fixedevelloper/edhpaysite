<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="cryptomus" content="3f159f83" />
    <title>{{env('APP_NAME')}} | </title>
    <!-- Icon Font Stylesheet -->
    <link href="{{ asset('multi/css/all.min.css') }}" rel="stylesheet">
  {{--  <link href="{{ asset('front/bootstrap-icons.css') }}" rel="stylesheet">--}}

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('multi/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('multi/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Bootstrap CSS -->
   {{-- <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">--}}
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="{{ asset('multi/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('multi/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('multi/select2/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('multi/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('multi/css/custom.css') }}">
</head>
<body>
<!-- Spinner Start
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div> -->
<!-- Spinner End -->
<!-- Begin page -->
<div id="wrappe">
@include('front._partials._header')
    @include("front._partials.errors-and-messages")
    @yield('content')
@include('front._partials._footer')
</div>
@stack('scripts')

<script src="{{ asset('multi/js/jquery.min.js') }}"></script>
<script src="{{ asset('multi/js/popper.min.js') }}"></script>
<script src="{{ asset('multi/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('multi/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('multi/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{asset('multi/js/calendar.min.js')}}"></script>
<script src="{{ asset('multi/select2/select2.min.js') }}"></script>
<script src="{{ asset('multi/js/main.js') }}"></script>
<script src="{{ asset('multi/js/script.js') }}"></script>
<script>
    var configs={
        routes:{
            index: "{{\Illuminate\Support\Facades\URL::to('/')}}",
            checkout: "{{\Illuminate\Support\Facades\URL::route('checkout')}}",
        }
    }
</script>
<script>
    $(function () {
        if ($('#virtual').is(':checked')){
            $('#contenu-virtual').show()
        }else {
            $('#contenu-virtual').hide()
        }
        if ($('#isdownloable').is(':checked')){
            $('#contenu-downloable').show()
        }else {
            $('#contenu-downloable').hide()
        }
        $('#isdownloable').change(function () {
            if ($(this).is(':checked')){
                $('#contenu-downloable').show()
            }else {
                $('#contenu-downloable').hide()
            }
        });
        $('#virtual').change(function () {
            if ($(this).is(':checked')){
                $('#contenu-virtual').show()
            }else {
                $('#contenu-virtual').hide()
            }
        });
        $("input[name='flexpersonnel']").change(function () {
          /*  $.ajax({
                url: configs.routes.calculplaning,
                type: "GET",
                dataType: "JSON",
                data: {
                    'user_id':$(this).val(),
                    'item':$('#soin_id').text(),
                },
                success: function (data) {
                    $('#cart_heure').html('')
                    $.each(data.data, function (index, item) {
                        $('#cart_heure').append("<a class='btn btn-outline-dark btn-sm m-1'>"+item+"</a>")
                    })

                },
                error: function (err) {
                    alert("An error ocurred while loading data ...");
                }
            });*/
        })
        $("#btn_cart").click(function () {
           $.ajax({
                  url: configs.routes.checkoutsession,
                  type: "GET",
                  dataType: "JSON",
                  data: {
                      'user_id':$("input[name='flexpersonnel']:checked").val(),
                      'item':$('#soin_id').text(),
                      'start':$('#time').text(),
                      'date':$('#fixture_date').val(),
                  },
                  success: function (data) {
                      window.location=configs.routes.checkout;
                  },
                  error: function (err) {
                      alert("An error ocurred while loading data ...");
                  }
              });
        })
    })
</script>
</body>

</html>
