<?php

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/prices', function () {
    return new \App\Http\Resources\PriceCollection(\App\Models\Price::paginate());
});

Route::post('/prices/{product_guid}', function (Request $request, string $product_guid) {
    return App\TestProject\Actions\UpdatePrices\UpdatePricesAction::run($product_guid, $request->input('prices'));
})->middleware(\App\Http\Middleware\HasProductMiddleware::class);

Route::get('/test', function (){
   return Price::where('product_guid', '9db161c6-6ae3-3c18-945e-09b93d28e871')->get();
});
