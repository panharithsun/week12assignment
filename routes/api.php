<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

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
Route::get('/users', [AuthController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/todos', [TodoController::class, 'index']);

Route::middleware('auth:api')->get('/todos/user/', [TodoController::class, 'get']);
Route::middleware('auth:api')->post('/todos/user/', [TodoController::class, 'create']);
Route::middleware('auth:api')->put('/todos/user/{id}', [TodoController::class, 'edit']);
Route::middleware('auth:api')->delete('/todos/user/{id}', [TodoController::class, 'delete']);

// Route::group(['prefix' => '/todos/user',  'middleware' => 'auth:api'], function()
// {
//     Route::get('/', [TodoController::class, 'get']);
//     Route::post('/create', [TodoController::class, 'create']);
//     Route::put('/{id}/edit', [TodoController::class, 'edit']);  
//     Route::delete('/{id}/delete', [TodoController::class, 'delete']);  
// });
