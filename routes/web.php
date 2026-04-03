<?php

use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\BannerController;

// User
use App\Http\Controllers\User\CurriculumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect()->route('admin.show.login');
})->name('login');


// ==============================
// User（通常ユーザー）
// ==============================
Route::name('user.')->group(function () {
    Route::get('/top', function () {
        return 'ユーザートップページ（仮）';
    })->name('show.top');

    Route::get('/curriculum_list', [CurriculumController::class, 'showCurriculumList'])
        ->name('show.curriculum');
});


// ==============================
// Admin（管理ユーザー）
// ==============================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('show.login');
    Route::post('/login', [AdminLoginController::class, 'store'])
        ->middleware('throttle:auth')
        ->name('login.store');

    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('show.register');
    Route::post('/register', [AdminRegisterController::class, 'store'])->name('register.store');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/top', [AdminTopController::class, 'index'])->name('show.top');
        Route::get('/banner_edit', [BannerController::class, 'showBannerEdit'])->name('show.banner.edit');
        Route::post('/banners', [BannerController::class, 'update'])->name('banners.update');

        Route::get('/curriculums', fn () => '授業管理（仮）')->name('curriculums.index');
        Route::get('/articles', fn () => 'お知らせ管理（仮）')->name('articles.index');

        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
    });
});