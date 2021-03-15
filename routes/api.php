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

Route::resource('kategori', 'KategoriController');
Route::resource('mentor', 'MentorController');
Route::resource('course', 'CourseController');
Route::resource('chapter', 'ChapterController');
Route::resource('lesson', 'LessonController');
Route::post('my-course/create', 'MyCourseController@create');
Route::get('my-course', 'MyCourseController@index');
Route::post('mentor/email/', 'MentorController@getByEmailMentoer');
