<?php

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


    # Generate Token
    Route::post('/token', function(Request $request){
        $user = $request->user();
        $ability = $request->has('abilities') ?  $request->input('abilities') : ['*'];


        return ['token' => $user->createToken('token-abilities', $ability)->plainTextToken ];
    });


    Route::post('/server-update', function(Request $request){
        $user = $request->user();
        if ($user->tokenCan('server:update')) {
            
            return "Server Updated";
        }

        return "No action allowed!";
    });

    #revoke token
    Route::delete('/token', function(Request $request){
        $user = $request->user();
        $user->tokens->each->delete();

        return "Token revoked!";
    });
});



Route::post('/login', function(Request $request){

    # validate request
    $request->validate([
    'email' => 'required|email',
    'password' => 'required'
    ]);
    
    
    $credentials = $request->only('email', 'password');
    if(!\Auth::once($credentials)){
        return ['error'=>"Invalid username / password"];
    }

    $user = \Auth::user();
    $token = $user->createToken('api-token');

    return ['token' => $token->plainTextToken];
});


