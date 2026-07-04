<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AIToolController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\CriterionWeightController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DecisionMatrixController;

// Dashboard Routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Master Data Resource Routes
Route::resource('ai-tools', AIToolController::class);
Route::resource('criteria', CriterionController::class);
Route::resource('criterion-weights', CriterionWeightController::class)->only(['index', 'store']);
Route::resource('project-types', ProjectTypeController::class);

// Project Assessment CRUD Routes
Route::resource('projects', ProjectController::class);

// Decision Matrix Routes
Route::get('matrix', [DecisionMatrixController::class, 'index'])->name('matrix.index');
Route::post('matrix', [DecisionMatrixController::class, 'store'])->name('matrix.store');

// Project TOPSIS Operations & Results
Route::post('projects/{project}/calculate', [ProjectController::class, 'calculateTopsis'])->name('projects.calculate');
Route::get('projects/{project}/results', [ProjectController::class, 'results'])->name('projects.results');
Route::get('projects/{project}/calculation', [ProjectController::class, 'calculationDetails'])->name('projects.calculation');

// Coming Soon Route for pending features
Route::view('coming-soon', 'errors.coming-soon')->name('coming-soon');
