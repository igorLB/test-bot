<?php

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

use App\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('chat');
})->name('conversar');

Route::get('/cadastros', function () {

    $users = User::orderBy('created_at', 'DESC')->get();

    return view('user-list', ['users' => $users]);
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');