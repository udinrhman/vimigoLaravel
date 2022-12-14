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
Route::get('/', [ClientControl::class,'home']);
Route::post('/filter', [ClientControl::class,'filter'])->name('filter');
Route::get('/todos/{id}/{page}',[ClientControl::class,'getUserTodos'])->name('posts.getusertodos');
Route::get('/posts/{id}/{page}',[ClientControl::class,'getUserPosts'])->name('posts.getuserposts');

Route::get('/users/page/{id}',[ClientControl::class,'getAllUser'])->name('posts.getalluser');
Route::post('/addUser', [ClientControl::class,'adduser'])->name('adduser');
Route::get('/profile/{id}',[ClientControl::class,'getUserProfile'])->name('posts.getuserprofile');
Route::post('/editUser', [ClientControl::class,'edituser'])->name('edituser');
Route::post('/deleteUser', [ClientControl::class,'deleteuser'])->name('deleteuser');

Route::post('/addPost', [ClientControl::class,'addpost'])->name('addpost');
Route::post('/editPost', [ClientControl::class,'editpost'])->name('editpost');
Route::post('/deletePost', [ClientControl::class,'deletepost'])->name('deletepost');

Route::post('/addComments', [ClientControl::class,'addcomment'])->name('addcomment');
Route::post('/deleteComments', [ClientControl::class,'deletecomment'])->name('deletecomment');

Route::post('/addTodos', [ClientControl::class,'addtodo'])->name('addtodo');
Route::post('/editTodos', [ClientControl::class,'edittodo'])->name('edittodo');
Route::post('/deleteTodos', [ClientControl::class,'deletetodo'])->name('deletetodo');
