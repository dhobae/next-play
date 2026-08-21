<?php

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

Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
    ->middleware('guest')->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->middleware('guest');
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->middleware('auth')->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('admin/beranda', [App\Http\Controllers\Admin\BerandaController::class, 'index'])->name('home');
    Route::prefix('admin/')->name('admin.')->group(function () {
        Route::get('profil', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
        Route::put('profil', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('profil/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::prefix('carousel')->name('carousel.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Beranda\CarouselController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\Beranda\CarouselController::class, 'store'])->name('store');
            Route::put('{carousel}', [App\Http\Controllers\Admin\Beranda\CarouselController::class, 'update'])->name('update');
            Route::delete('{carousel}', [App\Http\Controllers\Admin\Beranda\CarouselController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('sponsor')->name('sponsor.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Beranda\SponsorController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\Beranda\SponsorController::class, 'store'])->name('store');
            Route::put('{sponsor}', [App\Http\Controllers\Admin\Beranda\SponsorController::class, 'update'])->name('update');
            Route::delete('{sponsor}', [App\Http\Controllers\Admin\Beranda\SponsorController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('herottgkami')->name('hero.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\TentangKami\HeroController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\TentangKami\HeroController::class, 'store'])->name('store');
            Route::put('{hero}', [App\Http\Controllers\Admin\TentangKami\HeroController::class, 'update'])->name('update');
            Route::delete('{hero}', [App\Http\Controllers\Admin\TentangKami\HeroController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('heroatlet')->name('heroatlet.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Atlet\HeroController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\Atlet\HeroController::class, 'store'])->name('store');
            Route::put('{hero}', [App\Http\Controllers\Admin\Atlet\HeroController::class, 'update'])->name('update');
            Route::delete('{hero}', [App\Http\Controllers\Admin\Atlet\HeroController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('heroevent')->name('heroevent.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\EventAcara\HeroController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\EventAcara\HeroController::class, 'store'])->name('store');
            Route::put('{hero}', [App\Http\Controllers\Admin\EventAcara\HeroController::class, 'update'])->name('update');
            Route::delete('{hero}', [App\Http\Controllers\Admin\EventAcara\HeroController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('visimisi')->name('visimisi.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\TentangKami\VisiMisiController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\TentangKami\VisiMisiController::class, 'store'])->name('store');
            Route::put('{visimisi}', [App\Http\Controllers\Admin\TentangKami\VisiMisiController::class, 'update'])->name('update');
            Route::delete('{visimisi}', [App\Http\Controllers\Admin\TentangKami\VisiMisiController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('hubungikami')->name('hubungikami.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\HubungiKamiController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\HubungiKamiController::class, 'store'])->name('store');
            Route::put('{hubungiKami}', [App\Http\Controllers\Admin\HubungiKamiController::class, 'update'])->name('update');
        });
        Route::resource('eventacara', App\Http\Controllers\Admin\EventAcara\EventAcaraController::class)->except('show');
        Route::resource('atlet', App\Http\Controllers\Admin\Atlet\AtletController::class);
        Route::prefix('atlet-riwayat')->name('atlet-riwayat.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Atlet\AtletRiwayatController::class, 'index'])->name('index');
            Route::get('atlet/{atlet}', [App\Http\Controllers\Admin\Atlet\AtletRiwayatController::class, 'manage'])->name('manage');
            Route::post('atlet/{atlet}', [App\Http\Controllers\Admin\Atlet\AtletRiwayatController::class, 'store'])->name('store');
            Route::get('atlet/{atlet}/edit/{riwayat}', [App\Http\Controllers\Admin\Atlet\AtletRiwayatController::class, 'edit'])->name('edit');
            Route::put('atlet/{atlet}/riwayat/{riwayat}', [App\Http\Controllers\Admin\Atlet\AtletRiwayatController::class, 'update'])->name('update');
            Route::delete('atlet/{atlet}/riwayat/{riwayat}', [App\Http\Controllers\Admin\Atlet\AtletRiwayatController::class, 'destroy'])->name('destroy');
        });
    });
});

// user/pengunjung
Route::get('/', [App\Http\Controllers\User\BerandaController::class, 'index'])->name('beranda');
Route::get('tentang-kami', [App\Http\Controllers\User\TentangKamiController::class, 'index'])->name('tentangkami');
Route::get('events', [App\Http\Controllers\User\EventAcaraController::class, 'index'])->name('events');
Route::get('events/{event}', [App\Http\Controllers\User\EventAcaraController::class, 'show'])->name('events.show');
Route::get('atlets', [App\Http\Controllers\User\AtletController::class, 'index'])->name('atlets');
Route::get('atlets/{atlet}', [App\Http\Controllers\User\AtletController::class, 'show'])->name('atlets.show');



