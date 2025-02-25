<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminEmployeeController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/user', [AdminController::class, 'getUser']); // Get logged in admin user
    Route::post('/admin/logout', [AdminController::class, 'logout']); // Admin logout
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']); // Admin dashboard (example)
});

// Public Admin API Routes (no authentication required for these)
Route::post('/admin/register', [AdminController::class, 'register']); // Admin registration
Route::post('/admin/login', [AdminController::class, 'login'])->name('login');   // Admin login - **NAME THE ROUTE 'login'**


Route::prefix('admin')->group(function () { // Optional: Group under /api/admin prefix
    Route::get('employees', [AdminEmployeeController::class, 'index']);       // Get all employees
    Route::post('employees', [AdminEmployeeController::class, 'store']);      // Create new employee
    Route::get('employees/{id}', [AdminEmployeeController::class, 'edit']);    // Get employee for editing (or show)
    Route::put('employees/{id}', [AdminEmployeeController::class, 'update']);   // Update employee
    Route::delete('employees/{id}', [AdminEmployeeController::class, 'destroy']); // Delete employee
});

