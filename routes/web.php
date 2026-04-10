<?php

use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\CourtApiController;
use App\Http\Controllers\Api\EnumOptionsController;
use App\Http\Controllers\Api\LegalCaseApiController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\LegalCaseController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::prefix('api/v1')->group(function (): void {
    Route::get('meta/enums', [EnumOptionsController::class, 'index']);
    Route::get('meta/case-form', [EnumOptionsController::class, 'caseForm']);
    Route::get('users/options', [EnumOptionsController::class, 'users']);
    Route::apiResource('courts', CourtApiController::class);
    Route::apiResource('clients', ClientApiController::class);
    Route::apiResource('cases', LegalCaseApiController::class)->parameters(['cases' => 'case']);
});

Route::resource('courts', CourtController::class);
Route::resource('clients', ClientController::class);
Route::resource('cases', LegalCaseController::class);
