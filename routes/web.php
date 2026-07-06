<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AIToolController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\CriterionWeightController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DecisionMatrixController;
use App\Http\Controllers\AIToolMappingController;
use App\Http\Controllers\EvaluationHistoryController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

// Public Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Workspace Routes (Auth Required)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Shared AJAX endpoint for project form checkboxes initialization
    Route::get('project-types/{projectType}/ai-tools', [ProjectTypeController::class, 'getAiTools'])->name('project-types.ai-tools');

    // General Routes (Access control and query scoping enforced inside controllers)
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/calculate', [ProjectController::class, 'calculateTopsis'])->name('projects.calculate');
    Route::get('projects/{project}/results', [ProjectController::class, 'results'])->name('projects.results');
    Route::get('projects/{project}/calculation', [ProjectController::class, 'calculationDetails'])->name('projects.calculation');

    Route::get('matrix', [DecisionMatrixController::class, 'index'])->name('matrix.index');
    Route::post('matrix', [DecisionMatrixController::class, 'store'])->name('matrix.store');

    Route::get('history', [EvaluationHistoryController::class, 'index'])->name('history.index');
    Route::get('history/{assessment}', [EvaluationHistoryController::class, 'show'])->name('history.show');
    Route::get('history/{assessment}/pdf', [EvaluationHistoryController::class, 'exportPdf'])->name('history.pdf');

    // Admin & Manager Only Routes
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::get('statistics', [StatisticController::class, 'index'])->name('statistics.index');
    });

    // Administrator Only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('ai-tools', AIToolController::class);
        Route::resource('criteria', CriterionController::class);
        Route::resource('criterion-weights', CriterionWeightController::class)->only(['index', 'store']);
        Route::resource('project-types', ProjectTypeController::class)->except(['getAiTools']);
        
        Route::get('ai-mappings', [AIToolMappingController::class, 'index'])->name('ai-mappings.index');
        Route::get('ai-mappings/{projectType}/edit', [AIToolMappingController::class, 'edit'])->name('ai-mappings.edit');
        Route::put('ai-mappings/{projectType}', [AIToolMappingController::class, 'update'])->name('ai-mappings.update');
        
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});
