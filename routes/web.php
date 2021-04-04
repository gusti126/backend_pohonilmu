<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Admin\DashboardController@index')->middleware('auth');

Route::prefix('admin')->middleware(['auth', 'admin'])
->group(function(){
    // pengembang
    Route::resource('kel-pengembang', 'Manag\ManagPengembangController');
    Route::resource('kel-mentor', 'Manag\KelMentorController');
    Route::resource('kel-kememberan', 'Manag\KememberanController');

    // hadiah
    Route::get('hadiah', 'Manag\HadiahController@index')->name('index-hadiah');
    Route::get('hadiah/create', 'Manag\HadiahController@create')->name('create-hadiah');
    Route::post('hadiah/store', 'Manag\HadiahController@store')->name('hadiah-store');
    Route::get('hadiah/edit/{id}', 'Manag\HadiahController@edit')->name('edit-hadiah');
    Route::put('hadiah/update/{id}', 'Manag\HadiahController@update')->name('update-hadiah');
    Route::get('hadiah/delete/{id}', 'Manag\HadiahController@delete')->name('delete-hadiah');
    Route::get('hadiah/update/status/{id}', 'Manag\HadiahController@hendleSuksessHadiah')->name('hendle-hadiah-sukses');

    Route::get('kel-pendapatan', 'Manag\PendapatanKelasController@index')->name('pendapatan');
    Route::get('kel-transaksi', 'Manag\ManagTransaksiController@index')->name('kel-transaksi');

    // BERLANGGANAN
    Route::resource('kel-berlangganan', 'Manag\ManagBerlanggananController');
    // transaksi manual
    Route::get('set-transaksi/{id}', 'Manag\ManagTransaksiManualController@setSuksess')->name('set-sukses-transaksi');

});

Route::prefix('pengembang')->middleware(['auth'])->group(function(){
    Route::resource('pengajar', 'Admin\MentorController');
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::resource('kelas', 'Admin\KelasController');
    // materi
    Route::post('kelas/bab/create', 'Admin\MateriController@tambahBAB')->name('chapter-create');
    Route::get('kelas/materi/{id}', 'Admin\MateriController@getMateri')->name('materi');
    Route::get('kelas/edit/{course_id}/{id}', 'Admin\MateriController@editLesson')->name('edit-lesson');
    Route::put('kelas/update/{course_id}/{id}', 'Admin\MateriController@updateLesson')->name('update-lesson');
    Route::post('kelas/lesson/create/{id}', 'Admin\MateriController@createLesson')->name('create-lesson');
});
// Route::resource('dasho', 'Admin\MentorController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/keluar', '\App\Http\Controllers\Auth\LoginController@logout')->name('keluar');
