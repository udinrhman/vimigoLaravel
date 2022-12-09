<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientControl;

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
    return view('welcome');
});

Route::get('/users/page/{id}',[ClientControl::class,'getAllUser'])->name('posts.getalluser');
Route::get('/userTodos/{id}',[ClientControl::class,'getUserTodos'])->name('posts.getusertodos');
Route::post('/addUser', [ClientControl::class,'store'])->name('store');
