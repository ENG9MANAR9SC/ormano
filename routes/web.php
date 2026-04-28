<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LegalCaseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CourtApiController;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\DocumentApiController;
use App\Http\Controllers\Api\EnumOptionsController;
use App\Http\Controllers\Api\LegalCaseApiController;

Route::view('/', 'welcome');

Route::prefix('api/v1')->group(function (): void {
    Route::get('meta/enums', [EnumOptionsController::class, 'index']);
    Route::get('meta/case-form', [EnumOptionsController::class, 'caseForm']);
    Route::get('meta/task-form', [EnumOptionsController::class, 'taskForm']);
    Route::get('meta/document-form', [EnumOptionsController::class, 'documentForm']);
    Route::get('users/options', [EnumOptionsController::class, 'users']);
    Route::apiResource('courts', CourtApiController::class);
    Route::apiResource('clients', ClientApiController::class);
    Route::apiResource('cases', LegalCaseApiController::class)->parameters(['cases' => 'case']);
    Route::apiResource('tasks', TaskApiController::class);
    Route::apiResource('documents', DocumentApiController::class);
    Route::apiResource('users', UserApiController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
});


Route::resource('courts', CourtController::class);
Route::resource('clients', ClientController::class);
Route::resource('cases', LegalCaseController::class);
Route::get('tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');
Route::resource('tasks', TaskController::class);
Route::resource('documents', DocumentController::class);
Route::resource('users', UserController::class);
