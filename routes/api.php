<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user = $request->user();
    $user->town;
    $user->state;
    $user->discounts;
    $user->facturacion;
    $user->facturacion->state;
    $user->facturacion->town;
    $user->branch;
    return $user;

});


Route::get('/user/orders', [App\Http\Controllers\Front\CustomerController::class, 'orders']);

Route::get('/orders/check_duplicates/{rx}', [App\Http\Controllers\Front\OrdersController::class, 'checkDuplicate']);
Route::get('/types', [App\Http\Controllers\Front\TypesController::class, 'index']);

Route::get('/product/type/{type_id}', [App\Http\Controllers\Front\ProductsController::class, 'type']);
Route::get('/subcategories/type/{type_id}', [App\Http\Controllers\Front\SubcategoriesHasTypesController::class, 'byType']);

Route::post('/order', [App\Http\Controllers\Front\OrdersController::class, 'store']);
Route::post('/orders/requestrx', [App\Http\Controllers\Front\OrdersController::class, 'requestRxSave']);