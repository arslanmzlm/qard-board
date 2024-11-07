<?php

use App\Http\Controllers\FieldController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])
    ->prefix('/admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('fields', [FieldController::class, 'list'])->name('field.list');
        Route::get('field/create', [FieldController::class, 'create'])->name('field.create');
        Route::post('field/store', [FieldController::class, 'store'])->name('field.store');
        Route::get('field/edit/{field}', [FieldController::class, 'edit'])->name('field.edit');
        Route::post('field/update/{field}', [FieldController::class, 'update'])->name('field.update');
        Route::post('field/destroy/{field}', [FieldController::class, 'destroy'])->name('field.destroy');

        Route::get('companies', [CompanyController::class, 'list'])->name('company.list');
        Route::get('company/preview/{company}', [CompanyController::class, 'show'])->name('company.show');
        Route::get('company/create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('company/store', [CompanyController::class, 'store'])->name('company.store');
        Route::get('company/edit/{company}', [CompanyController::class, 'edit'])->name('company.edit');
        Route::post('company/update/{company}', [CompanyController::class, 'update'])->name('company.update');
        Route::post('company/destroy/{company}', [CompanyController::class, 'destroy'])->name('company.destroy');
        Route::post('company/active/{company}', [CompanyController::class, 'active'])->name('company.active');
        Route::post('company/passive/{company}', [CompanyController::class, 'passive'])->name('company.passive');
    });

require __DIR__ . '/auth.php';

Route::get('/', [PublicController::class, 'index'])->name('public.index');

Route::get('/{company:slug}', [PublicController::class, 'card'])->name('public.card');
