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
    Route::post('profile/update', 'ApiUserController@updateProfile');
    Route::get('riwayat-referal', 'ApiUserController@riwayatReferal');
    Route::post('logout', 'ApiAuthController@logout');
    // my course
    Route::get('my-course', 'MyCourseController@index');
    Route::post('my-course/create', 'MyCourseController@create');
    // order
    Route::post('order/create', 'ApiOrderController@create');
    // order by tripay
    Route::post('tripay/create', 'ApiTripayController@creata');
    Route::get('tripay/riwayat', 'ApiTripayController@riwayatTripay');
    // berlangganan
    Route::post('berlangganan/create', 'ApiBerlanggananController@create');
    // tukar hadiah
    Route::post('hadiah/tukar', 'ApiHadiahController@tukarHadiah');
    // transaksi manual
    Route::post('transaksi-manual/create', 'TransaksiManualController@create');
    Route::post('transaksi-manual/cek-pending/{id}', 'TransaksiManualController@isPending');


});



// user
Route::get('user', 'ApiUserController@index');
Route::get('user/{id}', 'ApiUserController@show');

// course
Route::resource('course', 'CourseController');
Route::resource('chapter', 'ChapterController');
Route::resource('lesson', 'LessonController');
Route::get('kelas/new', 'ApiCourseDuaController@kelasTerbaru');


// referal di controller user
Route::post('referal/cari', 'ApiUserController@cariReferal');
// Route::post('point/tambah', 'ApiUserController@tambahPoint');

Route::resource('kategori', 'KategoriController');
Route::resource('mentor', 'MentorController');


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

// order callback midtrans
Route::post('webhook', 'ApiOrderController@midtransHandler');

// callback tripay
Route::post('tripay/callback', 'ApiTripayController@handle');
