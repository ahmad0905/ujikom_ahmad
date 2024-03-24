<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');
Route::resource('/users', App\Http\Controllers\UserController::class);
Route::resource('/penjualans', App\Http\Controllers\PenjualanController::class);
Route::resource('/kasirs', App\Http\Controllers\KasirController::class);
Route::resource('/produks', App\Http\Controllers\ProdukController::class);
Route::resource('/detail_penjualan', App\Http\Controllers\DetailPenjualanController::class);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');
Route::get('/shop', 'App\Http\Controllers\HomeController@shop')->name('home.shop');
Route::get('/checkout', 'App\Http\Controllers\HomeController@checkout')->name('home.checkout');
Route::get('/about', 'App\Http\Controllers\HomeController@about')->name('home.about');
Route::get('/shopsingle', 'App\Http\Controllers\HomeController@shopsingle')->name('home.shopsingle');
Route::get('/thankyou', 'App\Http\Controllers\HomeController@thankyou')->name('home.thankyou');
// Route::get('profile', 'App\Http\Controllers\ProfileController@index');
// Route::get('edit-profile', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');;
// Route::post('profile', 'App\Http\Controllers\ProfileController@update');

Route::get('pesan/{id}', 'App\Http\Controllers\PesanController@index');
Route::post('pesan/{id}', 'App\Http\Controllers\PesanController@pesan');
Route::get('cart', 'App\Http\Controllers\PesanController@check_out');
Route::delete('check-out/{id}', 'App\Http\Controllers\PesanController@delete');

Route::get('konfirmasi-check-out', 'App\Http\Controllers\PesanController@konfirmasi');
Route::get('history', 'App\Http\Controllers\HistoryController@index');
Route::get('history/{id}', 'App\Http\Controllers\HistoryController@detail');




Route::get('/logout', 'App\Http\Controllers\DashboardController@logout')->name('dashboard.logout');

Route::get('/home', function () {
    return view('home.index');
});