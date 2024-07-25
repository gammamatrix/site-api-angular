<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (! empty(config('app.mock.api'))) {
    Route::group([
        'prefix' => 'api/cms',
        // 'middleware' => 'web',
    ], function () {

        Route::get('/pages', function (Request $request) {
            return response()->json(json_decode(file_get_contents(resource_path(
                // 'mock/pages-index-0.json'
                'mock/pages-index-1.json'
            )), true));
        });
        Route::post('/pages/index', function () {
            return response()->json(json_decode(file_get_contents(resource_path(
                // 'mock/pages-index-0.json'
                'mock/pages-index-1.json'
            )), true));
        });

        Route::get('/pages/{id}', function (string $id) {
            return response()->json(json_decode(file_get_contents(resource_path(
                'mock/page-detail.json'
            )), true));
        });

        Route::get('/snippets', function () {
            return response()->json(json_decode(file_get_contents(resource_path(
                // 'mock/snippet-index-0.json'
                'mock/snippet-index-1.json'
            )), true));
        });
        Route::post('/snippets/index', function () {
            return response()->json(json_decode(file_get_contents(resource_path(
                // 'mock/snippet-index-0.json'
                'mock/snippet-index-1.json'
            )), true));
        });

        Route::get('/snippets/{id}', function (string $id) {
            return response()->json(json_decode(file_get_contents(resource_path(
                'mock/snippet-detail.json'
            )), true));
        });

        Route::patch('/snippets/{id}', function (string $id) {
            return response()->json(json_decode(file_get_contents(resource_path(
                'mock/snippet-detail.json'
            )), true));
        });

        Route::get('/snippets/{id}/revisions', function () {
            return response()->json(json_decode(file_get_contents(resource_path(
                'mock/snippet-revisions-3.json'
            )), true));
        });
        Route::post('/snippets/{id}/revisions', function () {
            return response()->json(json_decode(file_get_contents(resource_path(
                'mock/snippet-revisions-3.json'
            )), true));
        });
    });
}
