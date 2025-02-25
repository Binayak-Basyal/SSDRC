<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogPostController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminEmployeeController;



Route::get('/', function () {
    return view('welcome');
});
Route::apiResource('blog-posts', BlogPostController::class)->middleware('auth:sanctum');


Route::get('/test-db', function() {
    try {
        DB::connection()->getPdo();
        return "Connected to: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Failed: " . $e->getMessage();
    }
});

Route::middleware(['auth:admin'])->group(function () {
    Route::resource('admin/employees', AdminEmployeeController::class);
});