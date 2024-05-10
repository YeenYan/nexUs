<?php

use App\Http\Controllers\{
 AuthController,
 HomePageController,
 UserAccountController,
 WorkspaceController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomePageController::class, 'landingPage'])->name('home');
// Route::get('signup', [HomePageController::class, 'signupPage'])->name('signup');
// Route::get('login', [HomePageController::class, 'loginPage'])->name('login');

/*************************************
 ********** AUTHENTICATION ***********
 ************************************/
Route::get('login', [AuthController::class, 'create'])->name('login');

/*************************************
 ******** USER REGISTRATION **********
 ************************************/
Route::resource('user-account', UserAccountController::class)
 ->only(['create']);


/*************************************
 ************ WORKSPACE **************
 ************************************/
Route::resource('workspace', WorkspaceController::class)
 ->only(['index', 'create']);
