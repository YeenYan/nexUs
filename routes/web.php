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
use App\Http\Controllers\Workspace\Sections\SectionsController;
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


Route::prefix('{workspace}')
  ->name('workspace.')
  ->middleware(['auth'])
  ->group(
    function () {
      // Dashboard routes
      Route::resource('dashboard', DashboardController::class)
        ->only(['index']);

      // Notifications routes
      Route::resource('notifications', NotificationsController::class)
        ->only(['index']);

      // Members routes
      Route::resource('members', MembersController::class)
        ->only(['index']);

      // Collection index route
      Route::get('{collection_id}', [CollectionsController::class, 'index'])->name('collections.index');

      // Collection update route
      Route::put('{collection_id}', [CollectionsController::class, 'update'])->name('collections.update');

      // Collection resource routes
      Route::resource('collections', CollectionsController::class)
        ->only(['store', 'destroy']);

      // Nested routes under a collection_id
      Route::prefix('{collection_id}')
        ->name('collection.')
        ->group(function () {

          // Section resource routes (store and update)
          Route::resource('sections', SectionsController::class)->only(['store', 'update', 'destroy']);

          // Section update route
          // Route::put('{section_id}', [SectionsController::class, 'update'])->name('sections.update');
        });
    }
  );


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
