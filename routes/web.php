<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Features\UserController;
use App\Http\Controllers\Features\DepartmentController;
use App\Http\Controllers\Features\QueueController;
use App\Http\Controllers\Features\CounterController;
use App\Http\Controllers\Setting\RoleController;

// ── Root ──────────────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login.form'));

// ── Auth pages (guest only) ───────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login.form')->middleware('nocache');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// ── Logout ────────────────────────────────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Queue public routes (no auth) ─────────────────────────────────────────────
Route::get('/queue/display',   [QueueController::class, 'display'])->name('queue.display');
Route::get('/queue/live-data', [QueueController::class, 'liveData'])->name('queue.live-data');

// ── Authenticated routes ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',         fn() => view('layouts.dashboard.profile'))->name('profile');
    Route::post('/profile-info',   [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/change-password', [LoginController::class, 'changePassword'])->name('password.update');

    // Users
    Route::resource('users', UserController::class)->middleware([
        'index'   => 'can:user.view',
        'create'  => 'can:user.create',
        'store'   => 'can:user.create',
        'edit'    => 'can:user.edit',
        'update'  => 'can:user.edit',
        'destroy' => 'can:user.delete',
    ]);

    // Roles
    Route::resource('roles', RoleController::class)->middleware([
        'index'   => 'can:role.view',
        'create'  => 'can:role.create',
        'store'   => 'can:role.create',
        'edit'    => 'can:role.edit',
        'update'  => 'can:role.edit',
        'destroy' => 'can:role.delete',
    ]);

    // Departments
    Route::resource('departments', DepartmentController::class)->middleware([
        'index'   => 'can:department.view',
        'create'  => 'can:department.create',
        'store'   => 'can:department.create',
        'edit'    => 'can:department.edit',
        'update'  => 'can:department.edit',
        'destroy' => 'can:department.delete',
    ]);

    // Counters
    Route::resource('counters', CounterController::class)->middleware([
        'index'   => 'can:counter.view',
        'create'  => 'can:counter.create',
        'store'   => 'can:counter.create',
        'edit'    => 'can:counter.edit',
        'update'  => 'can:counter.edit',
        'destroy' => 'can:counter.delete',
    ]);

    // Queue
    Route::prefix('queue')->name('queue.')->middleware('can:queue.view')->group(function () {
        Route::get('/',                           [QueueController::class, 'index'])->name('index');
        Route::post('/take',                      [QueueController::class, 'take'])->middleware('can:queue.create')->name('take');
        Route::post('/call-next',                 [QueueController::class, 'callNext'])->middleware('can:queue.edit')->name('call-next');
        Route::patch('/{queue}/skip',             [QueueController::class, 'skip'])->middleware('can:queue.edit')->name('skip');
        Route::patch('/{queue}/done',             [QueueController::class, 'done'])->middleware('can:queue.edit')->name('done');
        Route::patch('/counter/{counter}/toggle', [QueueController::class, 'toggleCounter'])->middleware('can:counter.edit')->name('counter.toggle');
    });

});