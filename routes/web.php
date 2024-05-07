<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\RolePermissionsController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view-dashboard');

    Route::get('users', [UserController::class, 'index'])->name('users')->middleware('permission:view-users');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create-users');
    Route::get('users/{userId}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role')->middleware('permission:assign-roles');
    Route::post('users/{userId}/assign-role', [UserController::class, 'updateAssignedRoles'])->name('users.assign-role')->middleware('permission:assign-roles');

    Route::get('roles', [RolePermissionsController::class, 'index'])->name('roles')->middleware('permission:view-roles');
    Route::post('roles', [RolePermissionsController::class, 'store'])->name('roles.store')->middleware('permission:create-roles');
    Route::get('roles/{id}/edit', [RolePermissionsController::class, 'edit'])->name('roles.edit')->middleware('permission:edit-roles');
    Route::put('roles/{id}', [RolePermissionsController::class, 'update'])->name('roles.update')->middleware('permission:edit-roles');
    Route::delete('/roles/{id}', [RolePermissionsController::class, 'destroy'])->name('roles.destroy')->middleware('permission:delete-roles');
    Route::get('roles/{role}/permissions', [RolePermissionsController::class, 'permissions'])->name('roles.permissions')->middleware('permission:manage-permissions');
    Route::post('roles/{role}/permissions', [RolePermissionsController::class, 'updatePermissions'])->name('roles.permissions')->middleware('permission:manage-permissions');

    Route::get('categories', [CategoriesController::class, 'index'])->name('categories')->middleware('permission:view-categories');
    Route::post('categories', [CategoriesController::class, 'store'])->name('categories.store')->middleware('permission:create-categories');
    Route::get('categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit')->middleware('permission:edit-categories');
    Route::put('categories/{id}', [CategoriesController::class, 'update'])->name('categories.update')->middleware('permission:edit-categories');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy')->middleware('permission:delete-categories');

    Route::get('/products', [ProductsController::class, 'index'])->name('products')->middleware('permission:view-products');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create')->middleware('permission:create-products');
    Route::post('/products/store', [ProductsController::class, 'store'])->name('products.store')->middleware('permission:create-products');
    Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit')->middleware('permission:edit-products');
    Route::post('/products/{id}/update', [ProductsController::class, 'update'])->name('products.update')->middleware('permission:edit-products');
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy')->middleware('permission:delete-products');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
