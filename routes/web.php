<?php

use App\Http\Controllers\{
  AuthController,
  HomePageController,
  UserAccountController,
  WorkspaceController
};

use App\Http\Controllers\Workspace\{
  DashboardController,
  MembersController,
  NotificationsController
};

use App\Http\Controllers\Workspace\Collections\CollectionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

/*************************************
 ********** AUTHENTICATION ***********
 ************************************/
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

/*************************************
 ******** USER REGISTRATION **********
 ************************************/
Route::resource('user-account', UserAccountController::class)
  ->only(['create', 'store']);


/*************************************
 ************ WORKSPACE **************
 ************************************/

Route::resource('workspace', WorkspaceController::class)
  ->middleware('auth')
  ->only(['index', 'create', 'store', 'show']);


Route::prefix('workspace/{workspace}')
  ->name('workspace.')
  ->middleware(['auth'])
  ->group(
    function () {
      Route::resource('dashboard', DashboardController::class)
        ->only(['index']);
      Route::resource('notifications', NotificationsController::class)
        ->only(['index']);
      Route::resource('members', MembersController::class)
        ->only(['index']);
      // Route::resource('collections', CollectionsController::class)
      //   ->only(['store']);
    }
  )
  ->group(function () {
    Route::resource('collections', CollectionsController::class)
      ->only(['index', 'show']);
  });


/*************************************
 *** SWITCHING BETWEEN WORKSPACES ****
 ************************************/
Route::post('/workspace/switch', [WorkspaceController::class, 'switchWorkspace'])->name('workspace.switch');

/*************************************
 *** NAVIGATE TO THE PREVIOUS PAGE ***
 ************************************/

Route::get('/previous', function () {
  return redirect()->back();
})->name('previous');
