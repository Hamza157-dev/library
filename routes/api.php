<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ِAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [ِAuthController::class, 'login']);
Route::post('register', [ِAuthController::class, 'register']);
Route::patch('changePassword', [ِAuthController::class, 'changePassword']);

Route::get('categories', [CategoryController::class, 'index']);
Route::apiResource('books', BookController::class)->only('index', 'show');
Route::apiResource('authors', AuthorController::class)->only('index');
// For testing: anyone can suggest (no auth). Revert to customer-only when done testing.
Route::post('books/suggest', [BookController::class, 'suggestBook']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ِAuthController::class, 'logout']);

    Route::middleware('user-type:customer')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/customer', 'show');
            Route::put('/customer', 'update');
        });
        Route::get('suggestions', [BookController::class, 'mySuggestions']);
    });


    Route::middleware('user-type:admin')->prefix('dashboard')->group(function () {

        Route::controller(CategoryController::class)
            ->prefix('/categories')->group(
                function () {
                    Route::post('', 'store');
                    Route::put('/{identifier}', 'update');
                    Route::delete('/{id}', 'destroy');
                }
            );

        Route::apiResource('books', BookController::class)->except('index', 'show');
        Route::apiResource('authors', AuthorController::class)->except('index', 'show');
        Route::get('suggestions', [BookController::class, 'indexSuggestions']);
    });
});
