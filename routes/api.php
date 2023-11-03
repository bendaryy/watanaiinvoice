<?php

use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\DetailsController;
use App\Http\Controllers\api\invoiceController;
use App\Http\Controllers\api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('details');
});

// Route::post('/drafinvoice',[invoiceController::class,'store'])->middleware('auth');

// this api's for user
Route::apiResource('/draft', invoiceController::class)->middleware('auth:sanctum');
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::post('/auth/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('store/details', [DetailsController::class, 'store'])->middleware('auth:sanctum');

// this api's for admins or systems
Route::post('/auth/register', [UserController::class, 'createUser'])->middleware('authkey');
Route::get('user/phone', [UserController::class, 'getUserByPhoneNumber'])->middleware('authkey');
Route::get('customer/name',[CustomerController::class,'showCustomerName'])->middleware('authkey');
Route::post('admin/store/details', [DetailsController::class, 'adminStore'])->middleware('authkey');
