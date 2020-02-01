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


/**
 * Login User
 */
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


/**
 * Generate Token for device
 */
Route::post('/device/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});


Route::middleware('auth:airlock')->group(function(){
    
    # Get authenticated User
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    # Get all tokens
    Route::get('/tokens', function(Request $request){
       return $request->user()->tokens; 
    });

    # Generate Token
    Route::post('/token', function(Request $request){
        $user = $request->user();
        $ability = $request->has('abilities') ?  $request->input('abilities') : ['*'];


        return ['token' => $user->createToken('token-abilities', $ability)->plainTextToken ];
    });

    # Check Token Abilities
    Route::post('/server-update', function(Request $request){
        $user = $request->user();
        if ($user->tokenCan('server:update')) {
            
            return "Server Updated";
        }

        return "No action allowed!";
    });

    # Revoke token.
    Route::delete('/token', function(Request $request){
        $user = $request->user();
        $user->tokens()->whereName($request->input('token_name'))->delete();

        return "Token revoked!";
    });

    # Revoke all tokens
    Route::delete('/tokens', function(Request $request){
        $user = $request->user();
        $user->tokens->each->delete();

        return "Token revoked!";
    });
});


