<?php

use App\User;
use Illuminate\Http\Request;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::middleware('auth:airlock')->group(function(){
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/tokens', function(Request $request){
       return $request->user()->tokens; 
    });
});



Route::post('/token', function(){
    $user = User::first();
    $token = $user->createToken('api-token');
    return $token->plainTextToken;
});