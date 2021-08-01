<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\DetalleAutorLibroController;
use App\Http\Controllers\LibroController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::resource('autor', AutorController::class); 
    Route::resource('editorial', EditorialController::class); 
    Route::resource('detallelibro', DetalleAutorLibroController::class); 
    Route::resource('libro', LibroController::class); 
});