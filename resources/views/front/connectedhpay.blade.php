<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{env('APP_NAME')}} | Connexion</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/icons.min.css')}}">
</head>
<body class="loading authentication-bg authentication-bg-pattern">
<div class="account-pages">
    <div class="container">

        <div class="row justify-content-center mt-3">
            <div class="col-md-4 col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body p-4">
                        <img class="w-50" src="{{asset('logo.jpg')}}">
                        <h4>Payer avec votre wallet <a>EDHPay</a></h4>
                        <dl class="row-md jh-entity-details">
                            <dt>Montant</dt>
                            <dd>{{round($order->total/$change,2)}} FCFA</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST">
                            {{csrf_field()}}
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Phone number</label>
                                <input class="form-control" name="phone" type="tel" id="phone" required="" placeholder="Votre email">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Pin</label>
                                <input class="form-control" maxlength="4" name="pin" type="password" required="" id="password" placeholder="Votre mot de passe">
                            </div>

                            <div class="mb-3 d-grid text-center">
                                <button class="btn btn-primary" type="submit"> Je valide </button>
                            </div>
                        </form>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<script src="{{asset('js/vendor.min.js') }}"></script>
<script src="{{asset('js/app.min.js') }}"></script>

</body>

</html>
