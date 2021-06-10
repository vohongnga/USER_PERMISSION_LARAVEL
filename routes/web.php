<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

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
    return  redirect()->route('home.index');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

Route::group(['prefix' => 'test/'], function () use ($router) {
    Route::get('index', [TestController::class,'index']);
});

Route::group(['prefix' => 'admin','middleware'=>'auth'], function () use ($router) {

    Route::resource('users', UserController::class);
    Route::post('/{id}/edit',[UserController::class,'postEdit'])->name('users.postEdit');
    Route::get('/user/{id}/change-password',[UserController::class,'showPassword'])->name('users.getChangePass');
    Route::put('/user/{id}/change-password',[UserController::class,'updatePassword'])->name('users.changePass');

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('/search',[UserController::class,'search'])->name('users.search');

});
