<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/






//login , register

Route::redirect('/', 'loginPage');

Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');

Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');








Route::middleware(['auth'])->group(function () {


    //dashboard

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');


    Route::middleware(['admin_auth'])->group(function(){
    //admin
    //category
    Route::prefix('category')->group(function () {
        Route::get('list', [CategoryController::class, 'list'])->name('category#list');
        Route::get('create/page',[CategoryController::class,'createPage'])->name('category#createPage');
        Route::post('create',[CategoryController::class,'create'])->name('create');
        Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
        Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
        Route::post('update',[CategoryController::class,'update'])->name('category#update');

    });




    Route::prefix('admin')->group(function(){

        Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
        Route::post('change/password',[AdminController::class,'changePassword'])->name('admin#changePassword');

        Route::get('details',[AdminController::class,'details'])->name('admin#details');
    });

  

});






    //user
    //home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        Route::get('home', function () {
            return view('user.home');
        })->name('user#home');
    });
});
