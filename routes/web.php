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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/pertanyaan', 'PertanyaanController@index');
    Route::get('/pertanyaansaya', 'PertanyaanController@indexsaya');
    Route::get('/pertanyaan/create', 'PertanyaanController@create');
    Route::post('/pertanyaan', 'PertanyaanController@store');
    Route::post('/pertanyaan/{id}', 'JawabanController@store');
    Route::get('/pertanyaan/{id}', 'PertanyaanController@show')->name('pertanyaan');
    Route::get('/pertanyaan/{id}/edit', 'PertanyaanController@edit');
    Route::put('/pertanyaan/{id}', 'PertanyaanController@update');
    Route::delete('/pertanyaan/{id}', 'PertanyaanController@destroy');
    Route::post('/pertanyaan/{id}/comment', 'KomentarController@store_p');
    Route::post('pertanyaan/{id}/jawaban/{id2}/comment', 'KomentarController@store_j');
    Route::post('/pertanyaan/vote/{id}', 'PertanyaanController@vote');
    Route::post('/pertanyaan/downvote/{id}', 'PertanyaanController@downvote');
    Route::post('/jawaban/vote/{tanyaid}/{id}', 'JawabanController@vote');
    Route::post('/jawaban/downvote/{tanyaid}/{id}', 'JawabanController@downvote');
    Route::post('/jawaban/solver/{tanyaid}/{id}', 'JawabanController@solver');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});