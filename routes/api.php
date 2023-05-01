<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AuthorController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/author')->group(function () {
    Route::get('/', [AuthorController::class, 'getAll']);
    Route::get('/{slug}', [AuthorController::class, 'show']);
    Route::put('/edit', [AuthorController::class, 'update']);
    Route::get('/remove/{id}', [AuthorController::class, 'delete']);
    Route::post('/add', [AuthorController::class, 'create']);
});

Route::prefix('/post')->group(function () {
    Route::get('/', [PostController::class, 'getAll']);
    Route::get('/{slug}', [PostController::class, 'show']);
    Route::put('/edit', [PostController::class, 'update']);
    Route::get('/remove/{id}', [PostController::class, 'delete']);
    Route::post('/add', [PostController::class, 'create']);
});

