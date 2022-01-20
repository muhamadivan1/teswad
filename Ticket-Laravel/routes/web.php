<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(); //bawaan library laravel-ui, gunanya supaya tidak membuat login register dari awal, bisa dilihat dari composer.json

Route::middleware(['auth'])->group(function () {    //mengatur hak akses atuh   middleware:untuk memvalidasi apakah udah login atau belum
    Route::get('/pengaturan', [App\Http\Controllers\UserController::class, 'create'])->name('pengaturan');
    Route::post('/edit/name', [App\Http\Controllers\UserController::class, 'name'])->name('edit.name');
    Route::post('/edit/password', [App\Http\Controllers\UserController::class, 'password'])->name('edit.password');
    Route::get('/about', [App\Http\Controllers\PemesananController::class, 'about'])->name('about');
    Route::get('/transaksi/{kode}', [App\Http\Controllers\LaporanController::class, 'show'])->name('transaksi.show');

    Route::middleware(['petugas'])->group(function () { //mengatur hak akses petugas
        Route::get('/pembayaran/{id}', [App\Http\Controllers\LaporanController::class, 'pembayaran'])->name('pembayaran');
        Route::get('/petugas', [App\Http\Controllers\LaporanController::class, 'petugas'])->name('petugas');
        Route::get('/about', [App\Http\Controllers\PemesananController::class, 'about'])->name('about');
        Route::post('/petugas', [App\Http\Controllers\LaporanController::class, 'kode'])->name('petugas.kode');

        Route::middleware(['admin'])->group(function () {   //mengatur hak akses admin
            Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
            Route::resource('/category', App\Http\Controllers\CategoryController::class);
            Route::resource('/transportasi', App\Http\Controllers\TransportasiController::class);
            Route::resource('/rute', App\Http\Controllers\RuteController::class);
            Route::resource('/user', App\Http\Controllers\UserController::class);
            Route::get('/transaksi', [App\Http\Controllers\LaporanController::class, 'index'])->name('transaksi');
            Route::get('/about', [App\Http\Controllers\PemesananController::class, 'about'])->name('about');
        });
    });

    Route::middleware(['penumpang'])->group(function () {   //mengatur hak akses penumpang
        Route::get('/pesan/{kursi}/{data}', [App\Http\Controllers\PemesananController::class, 'pesan'])->name('pesan');
        Route::get('/cari/kursi/{data}', [App\Http\Controllers\PemesananController::class, 'edit'])->name('cari.kursi');
        Route::resource('/', App\Http\Controllers\PemesananController::class);
        Route::get('/about', [App\Http\Controllers\PemesananController::class, 'about'])->name('about');
        Route::get('/history', [App\Http\Controllers\LaporanController::class, 'history'])->name('history');
        Route::get('/{id}/{data}', [App\Http\Controllers\PemesananController::class, 'show'])->name('show');
    });
});
