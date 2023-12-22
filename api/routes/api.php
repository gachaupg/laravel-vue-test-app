<?php

use App\Http\Controllers\BorrowController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Books;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('users' ,[AuthController::class,'user']);
Route::post('users/register' ,[AuthController::class,'register']);
Route::post('users/login' ,[AuthController::class,'login']);
Route::delete('users/delete/{id}' ,[AuthController::class,'destroy']);
Route::put('users/update/{id}' ,[AuthController::class,'update']);
Route::get('user/{id}' ,[AuthController::class,'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'userToken']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('books' ,[Books::class,'index']);
Route::post('books' ,[Books::class,'store']);
Route::delete('books/{id}' ,[Books::class,'destroy']);
Route::put('books/{id}' ,[Books::class,'update']);
Route::get('books/{id}' ,[Books::class,'show']);


Route::get('borrow',[BorrowController::class,'index']);
Route::put('borrow/{id}',[BorrowController::class,'borrowstate']);
Route::post('borrow' ,[BorrowController::class,'store']);
Route::delete('borrow/{id}' ,[BorrowController::class,'destroy']);
Route::put('borrow/{id}' ,[BorrowController::class,'update']);
Route::get('borrow/{id}' ,[BorrowController::class,'show']);
Route::put('borrow/return/{id}' ,[BorrowController::class,'updatereturn']);
Route::put('borrow/extend/{id}' ,[BorrowController::class,'exstate']);
