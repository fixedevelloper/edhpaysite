<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CongeController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\EstheticienController;
use App\Http\Controllers\Backend\FournisseurController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\shopController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\CallbackController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\SellerController;
use App\Http\Controllers\HomeComtroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [FrontController::class, 'home'])
    ->name('home');
Route::get('/startreservation', [FrontController::class, 'startreservation'])
    ->name('startreservation');
Route::get('/cart', [FrontController::class, 'cart'])
    ->name('cart');
Route::get('/addcart', [FrontController::class, 'addcart'])
    ->name('addcart');
Route::get('/shop', [FrontController::class, 'shop'])
    ->name('shop');
Route::get('/products', [FrontController::class, 'product'])
    ->name('products');
Route::get('/service', [FrontController::class, 'service'])
    ->name('services');
Route::get('/detailproduct/{slug}', [FrontController::class, 'detailproduct'])
    ->name('detailproduct');
Route::get('/categorieproducts/{slug}', [FrontController::class, 'categorieproducts'])
    ->name('categorieproducts');
Route::get('/shop_detail/{id}', [SellerController::class, 'shop_detail'])
    ->name('shop_detail');

Route::get('/downloadfile/{id}', [AccountController::class, 'downloadFile'])
    ->name('downloadfile');
Route::match(array('GET', 'POST'), '/become_seller', [SellerController::class, 'become_seller'])
    ->name('become_seller');
Route::match(array('GET', 'POST'), '/seller/dashboard', [SellerController::class, 'seller_dashboard'])
    ->name('seller_dashboard');
Route::match(array('GET', 'POST'), '/seller/addproduct', [SellerController::class, 'seller_add_product'])
    ->name('seller_add_product');
Route::get('/removesession', [FrontController::class, 'removesession'])
    ->name('removesession');
Route::get('/testpayement', [FrontController::class, 'testpayement'])
    ->name('testpayement');

Route::get('/redirect-payement', [FrontController::class, 'redirectpayement'])
    ->name('redirectpayement');
Route::get('/currency-change', [FrontController::class, 'currencychange'])
    ->name('currencychange');
Route::group(['prefix' => 'callback', 'as' => 'callback.'], function () {
    Route::match(array('GET', 'POST'), '/paydunya', [CallbackController::class, 'callbackpaydunya'])
        ->name('callbackpaydunya');
    Route::match(array('GET', 'POST'), '/flutterware', [CallbackController::class, 'callbackflutterware'])
        ->name('callbackflutterware');
    Route::match(array('GET', 'POST'), '/stripe-success', [CallbackController::class, 'callbackstripesuccess'])
        ->name('callbackstripesuccess');
    Route::match(array('GET', 'POST'), '/stripe-cancell', [CallbackController::class, 'callbackstripecancell'])
        ->name('callbackstripecancell');
    Route::match(array('GET', 'POST'), '/paypal-status', [CallbackController::class, 'paypalstatus'])
        ->name('paypal-status');
    Route::get('/payment-fail', [CallbackController::class, 'paymentfail'])
        ->name('payment-fail');
    Route::get('/payment-succes', [CallbackController::class, 'paymentsucces'])
        ->name('payment-succes');
});


Route::get('/contact', [FrontController::class, 'contact'])
    ->name('contact');
Route::get('/login', [AuthController::class, 'login'])
    ->name('login');
Route::get('/app/login', [AuthController::class, 'logincustomer'])
    ->name('logincustomer');
Route::get('/destroy', [AuthController::class, 'destroy'])
    ->name('destroy');
Route::post('/loginstore', [AuthController::class, 'loginstore'])
    ->name('loginstore');
Route::post('/loginstorecustomer', [AuthController::class, 'loginstorecustomer'])
    ->name('loginstorecustomer');
Route::match(array('GET', 'POST'), '/app/register', [AuthController::class, 'register'])
    //->middleware('guest')
    ->name('register');
Route::match(array('GET', 'POST'), '/reset_password', [AuthController::class, 'reset_password'])
    ->name('reset_password');
Route::match(array('GET', 'POST'), '/changeimage', [AuthController::class, 'changeimage'])
    ->name('changeimage');
Route::group(['middleware' => ['checkCustomer']], function () {
    Route::get('/app/account', [AccountController::class, 'account'])
        ->name('account');
    Route::match(array('GET', 'POST'), '/checkout', [FrontController::class, 'checkout'])
        ->name('checkout');
    Route::match(array('GET', 'POST'), '/showdetail/{order_key}', [FrontController::class, 'detailorder'])
        ->name('detailorder');
    Route::match(array('GET', 'POST'), '/app/profil', [AccountController::class, 'profil'])
        ->name('app.profil');
    Route::match(array('GET', 'POST'), '/connect-edhpay/{token}', [CallbackController::class, 'connectedhpay'])
        ->name('connectedhpay');
});
Route::group(['middleware' => ['auth', 'isAdmin']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::group(['prefix' => 'conge', 'as' => 'conge.'], function () {
        Route::match(array('GET', 'POST'), 'create', [CongeController::class, 'create'])
            ->name('create');
        Route::get('/list', [CongeController::class, 'index'])
            ->name('index');
        Route::get('/edit/{id}', [CongeController::class, 'edit'])
            ->name('edit');
        Route::post('/update/{id}', [CongeController::class, 'update'])
            ->name('update');
        Route::post('/store', [CongeController::class, 'store'])
            ->name('store');

    });
    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
        Route::match(array('GET', 'POST'), 'create', [CustomerController::class, 'create'])
            ->name('create');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])
            ->name('edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])
            ->name('update');
        Route::get('/list', [CustomerController::class, 'index'])
            ->name('index');
        Route::post('/store', [CustomerController::class, 'store'])
            ->name('store');
        Route::delete('/destroy', [CustomerController::class, 'destroy'])
            ->name('destroy');

    });
    Route::group(['prefix' => 'estheticien', 'as' => 'estheticien.'], function () {
        Route::match(array('GET', 'POST'), 'create', [EstheticienController::class, 'create'])
            ->name('create');
        Route::get('/edit/{id}', [EstheticienController::class, 'edit'])
            ->name('edit');
        Route::post('/update/{id}', [EstheticienController::class, 'update'])
            ->name('update');
        Route::get('/list', [EstheticienController::class, 'index'])
            ->name('index');
        Route::post('/store', [EstheticienController::class, 'store'])
            ->name('store');
        Route::delete('/destroy', [EstheticienController::class, 'destroy'])
            ->name('destroy');

    });
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::match(array('GET', 'POST'), 'create', [OrderController::class, 'create'])
            ->name('create');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])
            ->name('edit');
        Route::post('/update/{id}', [OrderController::class, 'update'])
            ->name('update');
        Route::get('/list', [OrderController::class, 'index'])
            ->name('index');
        Route::match(array('GET', 'POST'), '/customer', [OrderController::class, 'customer'])
            ->name('customer');
        Route::post('/store', [OrderController::class, 'store'])
            ->name('store');
        Route::delete('/destroy', [OrderController::class, 'destroy'])
            ->name('destroy');

    });
    Route::group(['prefix' => 'product_type', 'as' => 'product_type.'], function () {
        Route::match(array('GET', 'POST'), 'create', [CategoryController::class, 'create'])
            ->name('create');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->name('edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('update');
        Route::get('/list', [CategoryController::class, 'index'])
            ->name('index');
        Route::post('/store', [CategoryController::class, 'store'])
            ->name('store');
        Route::delete('/destroy', [CategoryController::class, 'destroy'])
            ->name('destroy');

    });
    Route::group(['prefix' => 'fournisseur', 'as' => 'fournisseur.'], function () {
        Route::match(array('GET', 'POST'), 'create', [FournisseurController::class, 'create'])
            ->name('create');
        Route::get('/edit/{id}', [FournisseurController::class, 'edit'])
            ->name('edit');
        Route::post('/update/{id}', [FournisseurController::class, 'update'])
            ->name('update');
        Route::get('/list', [FournisseurController::class, 'index'])
            ->name('index');
        Route::post('/store', [FournisseurController::class, 'store'])
            ->name('store');
        Route::delete('/destroy', [FournisseurController::class, 'destroy'])
            ->name('destroy');

    });
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::match(array('GET', 'POST'), 'create', [ProductController::class, 'create'])
            ->name('create');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])
            ->name('edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])
            ->name('update');
        Route::get('/list', [ProductController::class, 'index'])
            ->name('index');
        Route::post('/store', [ProductController::class, 'store'])
            ->name('store');
        Route::delete('/destroy', [ProductController::class, 'destroy'])
            ->name('destroy');

    });
    Route::group(['prefix' => 'seller', 'as' => 'seller.'], function () {
        Route::match(array('GET', 'POST'), 'create', [shopController::class, 'create'])
            ->name('create');
        Route::get('/edit/{id}', [shopController::class, 'edit'])
            ->name('edit');
        Route::get('/detail/{id}', [shopController::class, 'show'])
            ->name('detail');
        Route::post('/update/{id}', [shopController::class, 'update'])
            ->name('update');
        Route::get('/list', [shopController::class, 'index'])
            ->name('index');
        Route::get('/paiement', [shopController::class, 'paiement'])
            ->name('paiement');
        Route::post('/store', [shopController::class, 'store'])
            ->name('store');
        Route::delete('/destroy', [shopController::class, 'destroy'])
            ->name('destroy');

    });


    Route::get('/connexions', [HomeComtroller::class, 'connexion'])
        ->name('connexion');
    Route::get('/users', [HomeComtroller::class, 'users'])
        ->name('users');

    Route::get('/deletecalandar', [HomeComtroller::class, 'deleteCalandar'])
        ->name('deletecalandar');
    Route::match(array('GET', 'POST'), '/profil', [AuthController::class, 'profil'])
        ->name('profil');
    Route::match(array('GET', 'POST'), '/changepassword', [AuthController::class, 'changepassword'])
        ->name('changepassword');

    Route::get('/report/calendar', [HomeComtroller::class, 'reportCalendar'])
        ->name('reportcalandar');
});
Route::group(['middleware' => 'isAdmin'], function () {
    Route::match(array('GET', 'POST'), '/conge', [HomeComtroller::class, 'conge'])
        ->name('conge');
    Route::match(array('GET', 'POST'), '/periode', [HomeComtroller::class, 'periode'])
        ->name('periode');
    Route::match(array('GET', 'POST'), '/periode_edit/{id}', [HomeComtroller::class, 'periode_edit'])
        ->name('periode_edit');
    Route::match(array('GET', 'POST'), '/conge_edit/{id}', [HomeComtroller::class, 'conge_edit'])
        ->name('conge_edit');
    Route::match(array('GET', 'POST'), '/users/activate/{id}', [HomeComtroller::class, 'activate_or_desactivate'])
        ->name('activate_or_desactivate');
    Route::get('/delete_conge', [HomeComtroller::class, 'delete_conge'])
        ->name('delete_conge');
    Route::get('/delete_periode', [HomeComtroller::class, 'delete_periode'])
        ->name('delete_periode');
    Route::get('/connexions', [HomeComtroller::class, 'connexion'])
        ->name('connexion');
    Route::get('/users', [HomeComtroller::class, 'users'])
        ->name('users');
    Route::post('/users/sendmail', [HomeComtroller::class, 'sendmail'])
        ->name('sendmail');

});

