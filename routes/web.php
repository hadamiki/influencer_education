<?php

use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\TopController;
use App\Http\Controllers\Admin\BannerController;

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
// Admin（管理ユーザー）
// ==============================
Route::prefix('admin')->as('admin.')->group(function () {

    // ログイン表示
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('show.login');
    // ログイン処理
    Route::post('/login', [AdminLoginController::class, 'store'])->name('login.store');

    // 新規登録表示
    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('show.register');
    // 登録処理
    Route::post('/register', [AdminRegisterController::class, 'store'])->name('register.store');

    // ログイン後
    Route::middleware('auth:admin')->group(function () {

        // トップ
        Route::get('/top', [TopController::class, 'index'])->name('show.top');

        // バナー設定画面
        Route::get('/banner_edit', [BannerController::class, 'showBannerEdit'])->name('show.banner.edit');

        // バナー更新
        Route::post('/banners', [BannerController::class, 'update'])->name('banners.update');

        // 仮ルート
        Route::get('/curriculums', fn () => '授業管理（仮）')->name('curriculums.index');
        Route::get('/articles', fn () => 'お知らせ管理（仮）')->name('articles.index');

        // ログアウト
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
    });
});
