<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{app?}',[HomeController::class,'index'])->where('app','.*');
//Route::post('/broadcasting/auth', function () {
//    try {
//        dd("sds");
//        $user = JWTAuth::parseToken()->authenticate();
//        return response()->json(['success' => true, 'user' => $user->id]);
//    } catch (\Exception $e) {
//        return response()->json(['error' => 'Unauthorized'], 401);
//    }
//});
