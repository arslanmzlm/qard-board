<?php

use App\Http\Controllers\BankController;
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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::middleware(['auth'])
    ->prefix('/admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('banks', [BankController::class, 'list'])->name('bank.list');
        Route::get('bank/create', [BankController::class, 'create'])->name('bank.create');
        Route::post('bank/store', [BankController::class, 'store'])->name('bank.store');
        Route::get('bank/edit/{bank}', [BankController::class, 'edit'])->name('bank.edit');
        Route::post('bank/update/{bank}', [BankController::class, 'update'])->name('bank.update');
        Route::post('bank/destroy/{bank}', [BankController::class, 'destroy'])->name('bank.destroy');

        Route::get('platforms', [PlatformController::class, 'list'])->name('platform.list');
        Route::get('platform/create', [PlatformController::class, 'create'])->name('platform.create');
        Route::post('platform/store', [PlatformController::class, 'store'])->name('platform.store');
        Route::get('platform/edit/{platform}', [PlatformController::class, 'edit'])->name('platform.edit');
        Route::post('platform/update/{platform}', [PlatformController::class, 'update'])->name('platform.update');
        Route::post('platform/destroy/{platform}', [PlatformController::class, 'destroy'])->name('platform.destroy');

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
