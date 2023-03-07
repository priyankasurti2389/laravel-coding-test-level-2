<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

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

Route::post('users', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'login']);
Route::get('v1/projects', [ProjectController::class, 'index']);

Route::group(['middleware' => ['auth:api', 'checkHeader']], function () {
    Route::apiResource('projects', ProjectController::class);
    Route::post('projects/assign', [ProjectController::class, 'assignProjectToUser']);

    Route::apiResource('tasks', TaskController::class);
    Route::post('tasks/status/update', [TaskController::class, 'updateTaskStatus']);

    // Route::apiResource('users', UserController::class);
    Route::put('users/{:id}', [UserController::class, 'update']);
    Route::get('users/{:id}', [UserController::class, 'show']);
    Route::delete('users/{:id}', [UserController::class, 'destroy']);
    Route::get('users', [UserController::class, 'index']);
});


