<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth','admin'])->name('admin.')->prefix('admin')->group(function(){
Route::get('dashboard',[AdminController::class,'index'])->name('dashboard');
Route::get('reservations',[AdminController::class,"reservations"])->name('reservations');
Route::get('users',[AdminController::class,"users"])->name('users');
Route::get('users/create',[AdminController::class,"createUser"])->name('users.create');
Route::get('drivers',[AdminController::class,'drivers'])->name('drivers');
Route::get('rides',[AdminController::class,'rides'])->name('rides');
});


Route::middleware(['auth','driver'])->name('driver.')->prefix('driver')->group(function(){
    Route::get('dashboard',[DriverController::class,'index'])->name('dashboard');
    Route::get('reservations',[DriverController::class,'reservations'])->name('reservations');
});
Route::middleware(['auth','customer'])->name('customer.')->prefix('customer')->group(function(){
    Route::get('dashboard',[CustomerController::class,'index'])->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
