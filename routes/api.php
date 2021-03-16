<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\NumberController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\AcceptanceCertificateController;
use App\Http\Controllers\API\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
//Vue JS API Routs

Route::apiResources(
	[
        '/user' => UserController::class,
        '/user/{user}/company' => CompanyController::class,
        '/user/{user}/company/{company}/invoice' => InvoiceController::class,
        'user/{user}/company/{company}/customer' => CustomerController::class,
        'user/{user}/company/{company}/acceptance_certificate' => AcceptanceCertificateController::class,
        'user/{user}/company/{company}/product' => ProductController::class,
        '/number' => NumberController::class,
        //'/invoice' => InvoiceController::class,
        //'/product' => ProductController::class,
        //'/customer' => CustomerController::class,
        //'/acceptance_certificate' => AcceptanceCertificateController::class,
    ],
);
