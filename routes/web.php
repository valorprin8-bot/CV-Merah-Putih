<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik Website CV. Merah Putih (Tanpa Login & Tanpa Link Admin)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/mobil', [PublicController::class, 'vehicles'])->name('vehicles.index');
Route::get('/mobil/{vehicle}', [PublicController::class, 'vehicleShow'])
    ->whereNumber('vehicle')
    ->name('vehicles.show');
Route::get('/layanan', [PublicController::class, 'services'])->name('services.index');
Route::get('/blog', [PublicController::class, 'blog'])->name('blog.index');
Route::get('/blog/{article}', [PublicController::class, 'articleShow'])
    ->whereNumber('article')
    ->name('blog.show');
Route::get('/tentang-kami', [PublicController::class, 'about'])->name('about');

/*
|--------------------------------------------------------------------------
| Autentikasi Panel Administrator Tersembunyi (/portal-admin)
|--------------------------------------------------------------------------
*/
Route::prefix('portal-admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Dashboard & Manajemen CMS Admin (Wajib Login + Role Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelola Kendaraan (CRUD + Ubah Cepat Status Tersedia/Disewa)
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])
            ->whereNumber('vehicle')
            ->name('vehicles.edit');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
            ->whereNumber('vehicle')
            ->name('vehicles.update');
        Route::patch('/vehicles/{vehicle}/toggle-status', [VehicleController::class, 'toggleStatus'])
            ->whereNumber('vehicle')
            ->name('vehicles.toggle-status');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])
            ->whereNumber('vehicle')
            ->name('vehicles.destroy');

        // Kelola Artikel & Promo Blog (CRUD)
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
            ->whereNumber('article')
            ->name('articles.edit');
        Route::put('/articles/{article}', [ArticleController::class, 'update'])
            ->whereNumber('article')
            ->name('articles.update');
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
            ->whereNumber('article')
            ->name('articles.destroy');

        // Kelola Layanan (Tambah/Edit/Hapus) & Syarat Ketentuan Umum
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceController::class, 'update'])
            ->whereNumber('service')
            ->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])
            ->whereNumber('service')
            ->name('services.destroy');
        Route::put('/terms', [ServiceController::class, 'updateTerms'])->name('terms.update');

        // Profil Perusahaan (Identitas, Visi/Misi, Upload Logo, Foto Hero & Tentang Kami)
        Route::get('/profile', [CompanyProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [CompanyProfileController::class, 'update'])->name('profile.update');

        // Akun Administrator (Update Nama, Email & Ganti Kata Sandi)
        Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    });
});