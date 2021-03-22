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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// user
Route::get('user', 'ApiUserController@index');
Route::get('user/{id}', 'ApiUserController@show');
Route::get('profile', 'ApiUserController@profile');
// referal di controller user
Route::post('referal/cari', 'ApiUserController@cariReferal');
Route::post('point/tambah', 'ApiUserController@tambahPoint');

Route::resource('kategori', 'KategoriController');
Route::resource('mentor', 'MentorController');
Route::resource('course', 'CourseController');
Route::resource('chapter', 'ChapterController');
Route::resource('lesson', 'LessonController');
Route::post('my-course/create', 'MyCourseController@create');
Route::get('my-course', 'MyCourseController@index');
Route::post('mentor/email/', 'MentorController@getByEmailMentoer');

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
Route::post('berlangganan/create', 'ApiBerlanggananController@create');

// order
Route::post('order/create', 'ApiOrderController@create');
Route::post('webhook', 'ApiOrderController@midtransHandler');
