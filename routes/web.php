<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

//Route::view('/', 'items');
  Route::middleware('auth')->get('/me', function (Request $request) {
    return response()->json($request->user());
   });
Route::view('/', 'dashboard');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register');
Route::view('/items', 'items')->middleware('auth');
Route::view('/dashboard', 'dashboard');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::post('/register', [RegisterController::class, 'register']);
