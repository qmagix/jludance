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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Route::group(['middleware' => ['auth']], function() {
//   Route::get('students',['as'=>'students.index','uses' => 'StudentsController@index']);
// }

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/students','StudentsController@index')->name('students');
Route::get('/students/active','StudentsController@active')->name('activestudents');
Route::get('/students/waiting','StudentsController@waiting')->name('waitingstudents');
Route::get('/students/done','StudentsController@done')->name('waitingstudents');
Route::get('/students/{classid}','StudentsController@inclass')->name('studentsinclass');

Route::get('/classes','KlassController@index')->name('klasses');
Route::get('/classes/active','KlassController@active')->name('activeklasses');
Route::get('/classes/students/{classid}','KlassController@students')->name('studentsinklass');
Route::post('/classes/email', 'KlassController@email')->name('emailklass');;
Route::get('/classes/{klass}', 'KlassController@show');
