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

// Dashboard Routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Master Data Resource Routes
Route::resource('ai-tools', AIToolController::class);
Route::resource('criteria', CriterionController::class);
Route::resource('criterion-weights', CriterionWeightController::class)->only(['index', 'store']);
Route::resource('project-types', ProjectTypeController::class);
Route::get('project-types/{projectType}/ai-tools', [ProjectTypeController::class, 'getAiTools'])->name('project-types.ai-tools');

// AI Mapping Routes
Route::get('ai-mappings', [AIToolMappingController::class, 'index'])->name('ai-mappings.index');
Route::get('ai-mappings/{projectType}/edit', [AIToolMappingController::class, 'edit'])->name('ai-mappings.edit');
Route::put('ai-mappings/{projectType}', [AIToolMappingController::class, 'update'])->name('ai-mappings.update');

// Project Assessment CRUD Routes
Route::resource('projects', ProjectController::class);

// Decision Matrix Routes
Route::get('matrix', [DecisionMatrixController::class, 'index'])->name('matrix.index');
Route::post('matrix', [DecisionMatrixController::class, 'store'])->name('matrix.store');

// Project TOPSIS Operations & Results
Route::post('projects/{project}/calculate', [ProjectController::class, 'calculateTopsis'])->name('projects.calculate');
Route::get('projects/{project}/results', [ProjectController::class, 'results'])->name('projects.results');
Route::get('projects/{project}/calculation', [ProjectController::class, 'calculationDetails'])->name('projects.calculation');

// Evaluation History, PDF, Activity Logs, and Statistics
Route::get('history', [EvaluationHistoryController::class, 'index'])->name('history.index');
Route::get('history/{assessment}', [EvaluationHistoryController::class, 'show'])->name('history.show');
Route::get('history/{assessment}/pdf', [EvaluationHistoryController::class, 'exportPdf'])->name('history.pdf');
Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
Route::get('statistics', [StatisticController::class, 'index'])->name('statistics.index');

// Coming Soon Route for pending features
Route::view('coming-soon', 'errors.coming-soon')->name('coming-soon');

