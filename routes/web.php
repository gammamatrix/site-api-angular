<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::post('/api/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return ['token' => $token->plainTextToken];
// });

Route::group([
    'prefix' => 'api',
    'middleware' => [
        'web',
        // 'cors',
    ],
    'namespace' => 'App\Http\Controllers',
], function () {

    Route::post('/login', [
        'as' => 'login.post',
        'uses' => 'LoginController@authenticate',
    ]);

    Route::get('/token', [
        'as' => 'token',
        'uses' => 'LoginController@token',
    ]);

});

Route::group([
    'prefix' => 'api/sanctum',
    'middleware' => [
        'web',
        // 'cors',
    ],
    'namespace' => '\Laravel\Sanctum\Http\Controllers',
], function () {
    Route::get(
        '/csrf-cookie',
        CsrfCookieController::class.'@show'
    );
});
