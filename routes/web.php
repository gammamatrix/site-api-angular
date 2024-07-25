<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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

    Route::post('/logout', [
        'uses' => 'LoginController@logout',
    ]);

    Route::get('/logout', [
        'as' => 'logout',
        'uses' => 'LoginController@logout',
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
