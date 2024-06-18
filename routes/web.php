<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\AuthController;




Route::get('/', function () {
    return view('user.login');
});

Route::match(['get','post'],"/register",[AuthController::class,'register'])->name('register');
Route::match(['get','post'],"/login",[AuthController::class,'login'])->name('login');   //Login
Route::get("/dashboard",[AuthController::class,'dashboard'])->name('user.dashboard');   //Dashboard

Route::get('/profiles',[ProfilesController::class,'index'])->name('profiles.index');
Route::get('/profiles/{profile}/edit',[ProfilesController::class,'edit'])->name('profiles.edit');
Route::get('/profiles/create',[ProfilesController::class,'create'])->name('profiles.create');
Route::post('/profiles',[ProfilesController::class,'store'])->name('profiles.store');
Route::put('/profiles/{profile}',[ProfilesController::class,'update'])->name('profiles.update');
Route::delete('/profiles/{profile}',[ProfilesController::class,'destroy'])->name('profiles.destroy');
Route::get('/profiles/{profile}',[ProfilesController::class,'view_file'])->name('profiles.view_file');
