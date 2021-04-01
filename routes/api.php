<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login' , 'ApiAuthController@login');
Route::post('register', 'ApiAuthController@register');

Route::middleware('auth:api')->group(function () {
    // user
    Route::get('profile', 'ApiUserController@profile');
    Route::post('logout', 'ApiAuthController@logout');
    // my course
    Route::get('my-course', 'MyCourseController@index');
    Route::post('my-course/create', 'MyCourseController@create');
    // order
    Route::post('order/create', 'ApiOrderController@create');
    // berlangganan
    Route::post('berlangganan/create', 'ApiBerlanggananController@create');
    // tukar hadiah
    Route::post('hadiah/tukar', 'ApiHadiahController@tukarHadiah');

});



// user
Route::get('user', 'ApiUserController@index');
Route::get('user/{id}', 'ApiUserController@show');

// referal di controller user
Route::post('referal/cari', 'ApiUserController@cariReferal');
// Route::post('point/tambah', 'ApiUserController@tambahPoint');

Route::resource('kategori', 'KategoriController');
Route::resource('mentor', 'MentorController');
Route::resource('course', 'CourseController');
Route::resource('chapter', 'ChapterController');
Route::resource('lesson', 'LessonController');

// review
Route::get('review', 'ReviewController@index');
Route::get('review/{id}', 'ReviewController@show');
Route::post('review/create', 'ReviewController@create');
Route::delete('review/{id}', 'ReviewController@destroy');

// hadiah
Route::get('hadiah', 'ApiHadiahController@index');
Route::get('hadiah/{id}', "ApiHadiahController@show");

// kememberan
Route::get('kememberan', 'ApiKememberanController@index');
Route::get('kememberan/{id}', 'ApiKememberanController@show');

// berlangganan
Route::get('berlangganan', 'ApiBerlanggananController@index');
Route::delete('berlangganan/{id}', 'ApiBerlanggananController@destroy');

// order
Route::post('webhook', 'ApiOrderController@midtransHandler');
