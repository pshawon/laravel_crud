<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('user.login');
});

Route::match(['get','post'],"/register",[AuthController::class,'register'])->name('register');
Route::match(['get','post'],"/login",[AuthController::class,'login'])->name('login');   //Login
Route::get("/dashboard/{id}",[AuthController::class,'dashboard'])->name('user.dashboard');   //Dashboard
Route::get("/dashboard/{id}/view",[AuthController::class,'user_view'])->name('user.view');  //View user info
Route::get('/dashboard/{id}/edit',[AuthController::class,'user_edit'])->name('user.edit'); //Edit user info
Route::put('/dashboard/{id}',[AuthController::class,'user_update'])->name('user.update'); //Update user info
Route::get("/logout",[AuthController::class,'logout'])->name('user.logout'); //Logout




Route::get('/profiles',[ProfilesController::class,'index'])->name('profiles.index');
Route::get('/profiles/{profile}/edit',[ProfilesController::class,'edit'])->name('profiles.edit');
Route::get('/profiles/create',[ProfilesController::class,'create'])->name('profiles.create');
Route::post('/profiles',[ProfilesController::class,'store'])->name('profiles.store');
Route::put('/profiles/{profile}',[ProfilesController::class,'update'])->name('profiles.update');
Route::delete('/profiles/{profile}',[ProfilesController::class,'destroy'])->name('profiles.destroy');
Route::get('/profiles/{profile}',[ProfilesController::class,'view_file'])->name('profiles.view_file');


Route::get('/search', [ProfilesController::class, 'profile_search'])->name('profiles.search');

