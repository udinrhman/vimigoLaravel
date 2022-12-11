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
Route::post('/addUser', [ClientControl::class,'adduser'])->name('adduser');
Route::get('/profile/{id}',[ClientControl::class,'getUserProfile'])->name('posts.getuserprofile');
Route::post('/editUser', [ClientControl::class,'edituser'])->name('edituser');
Route::post('/addPost', [ClientControl::class,'addpost'])->name('addpost');
Route::post('/addTodos', [ClientControl::class,'addtodo'])->name('addtodo');
Route::post('/editTodos', [ClientControl::class,'edittodo'])->name('edittodo');
Route::post('/deleteTodos', [ClientControl::class,'deletetodo'])->name('deletetodo');
