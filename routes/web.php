<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;






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



Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);             
    Route::post('/list', [UserController::class, 'list']);         
    Route::get('/create', [UserController::class, 'create']);      
    Route::post('/', [UserController::class, 'store']);             
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); 
    Route::post('/ajax', [UserController::class, 'store_ajax']); 
    Route::get('/{id}', [UserController::class, 'show']);       
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);    
    Route::get('/{id}/edit', [UserController::class, 'edit']);     
    Route::put('/{id}', [UserController::class, 'update']);         
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); 
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); 
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');
    Route::get('/create', [LevelController::class, 'create'])->name('level.create');
    Route::post('/', [LevelController::class, 'store'])->name('level.store');
    Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/list', [KategoriController::class, 'list'])->name('kategori.list');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});


Route::prefix('supplier')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/list', [SupplierController::class, 'list'])->name('supplier.list');
    Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});


Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/list', [BarangController::class, 'list'])->name('barang.list');
    Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
});


Route::prefix('stok')->group(function () {
    Route::get('/', [StokController::class, 'index'])->name('stok.index');
    Route::get('/list', [StokController::class, 'list'])->name('stok.list');
    Route::get('/create', [StokController::class, 'create'])->name('stok.create');
    Route::post('/', [StokController::class, 'store'])->name('stok.store');
    Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/{id}', [StokController::class, 'update'])->name('stok.update');
    Route::delete('/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
});


Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::put('/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
});


Route::group(['prefix' => 'PenjualanDetail'], function () {
    Route::get('/', [PenjualanDetailController::class, 'index'])->name('PenjualanDetail.index');
    Route::get('/create', [PenjualanDetailController::class, 'create'])->name('PenjualanDetail.create');
    Route::post('/', [PenjualanDetailController::class, 'store'])->name('PenjualanDetail.store');
    Route::get('/{id}/edit', [PenjualanDetailController::class, 'edit'])->name('PenjualanDetail.edit');
    Route::put('/{id}', [PenjualanDetailController::class, 'update'])->name('PenjualanDetail.update');
    Route::delete('/{id}', [PenjualanDetailController::class, 'destroy'])->name('PenjualanDetail.destroy');
});


Route::get('/get-harga-barang/{id}', [PenjualanDetailController::class, 'getHargaBarang'])->name('get-harga-barang');