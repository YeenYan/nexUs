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
use App\Http\Controllers\Workspace\Activity\ActivityController;
use App\Http\Controllers\Workspace\Collections\CollectionsController;
use App\Http\Controllers\Workspace\Sections\SectionsController;
use App\Http\Controllers\Workspace\Tasks\TaskController;
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

Route::post('send-invite', [UserAccountController::class, 'sendInvite'])->name('email.invite');

Route::get('{workspace}/uuids/{owner_id}/{member_id}', [UserAccountController::class, 'success_email'])->name('success.index');

Route::post('{workspace}/uuids/{owner_id}/{member_id}', [UserAccountController::class, 'add_member_to_workspace'])
  ->name('add_member');


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

          // Specific Section Route
          Route::get('{section_id}', [SectionsController::class, 'show'])
            ->name('sections.show');

          /*================================================================
          =========================== TASK ROUTES ==========================
          ================================================================*/
          Route::prefix('{section_id}')
            ->name('section.')
            ->group(function () {

              // Route::post('send-invite', [UserAccountController::class, 'sendInvite'])->name('email.invite');

              Route::resource('task', TaskController::class)
                ->only(['store', 'destroy']);

              Route::get('{task_id}', [TaskController::class, 'show'])
                ->name('task.show');

              // Task Route for updating Priority Type
              Route::put('{task_id}/update_priority', [TaskController::class, 'update_priority'])
                ->name('task.update_priority');

              // Task Route for updating Starred value
              Route::put('{task_id}/update_starred', [TaskController::class, 'update_starred'])
                ->name('task.update_starred');

              // Task Route for updating Starred value
              Route::put('{task_id}/update_taskName', [TaskController::class, 'update_taskName'])
                ->name('task.update_taskName');

              /*================================================================
              ======================== ACTIVITY ROUTES =========================
              ================================================================*/
              Route::prefix('{task_id}')
                ->name('task.')
                ->group(function () {
                  Route::resource('activity', ActivityController::class)
                    ->only(['store', 'destroy']);


                  // Activity Route for updating Activity Name
                  Route::put('{activity_id}/update_activity_name', [ActivityController::class, 'update_activity_name'])
                    ->name('activity.update_activity_name');

                  // Activity Route for updating Priority Type
                  Route::put('{activity_id}/update_priority', [ActivityController::class, 'update_priority'])
                    ->name('activity.update_priority');

                  // Activity Route for updating Priority Type
                  Route::put('{activity_id}/update_status', [ActivityController::class, 'update_status'])
                    ->name('activity.update_status');

                  // Activity Route for updating Priority Type
                  Route::put('{activity_id}/update_due_date', [ActivityController::class, 'update_due_date'])
                    ->name('activity.update_due_date');

                  // Activity Route for updating Descrption
                  Route::put('{activity_id}/update_description', [ActivityController::class, 'update_description'])
                    ->name('activity.update_description');
                });
            });
        });
    }
  );
// Route::put('{activity_id}/update_priority', [ActivityController::class, 'update_priority'])
//   ->name('activity.update_priority');


/*************************************
 *** SWITCHING BETWEEN WORKSPACES ****
 ************************************/
Route::post('/workspace/switch', [WorkspaceController::class, 'switchWorkspace'])->name('workspace.switch');

/************************************************
 *** ADDING MEMBER TO WORKSPACE_COLLAB TABLE ****
 ***********************************************/


/*************************************
 *** NAVIGATE TO THE PREVIOUS PAGE ***
 ************************************/

Route::get('/previous', function () {
  return redirect()->back();
})->name('previous');
