<?php

use App\Students;
// Auth
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'checkRole:admin,penulis,pengurus']], function () {
    // Admin
    Route::get('/admin', 'DashboardController@index');

    // artikel
    Route::get('/artikel', 'ArtikelController@index')->name('artikel');
    Route::get('/artikel/new-artikel', 'ArtikelController@newArtikel');
    Route::post('/artikel/add-artikel', [
        'uses' => 'ArtikelController@store',
        'as' => 'artikel.post'
    ]);
    Route::get('/artikel/edit-artikel/{artikel}', 'ArtikelController@editArtikel');
    Route::post('/artikel/update-artikel/{artikel}', [
        'uses' => 'ArtikelController@update',
        'as' => 'artikel.update'
    ]);
    Route::get('/artikel/delete-artikel/{artikel}', 'ArtikelController@destroy');
    Route::get('/artikel/show/{artikel}', 'ArtikelController@show');

    Route::get('/kategori', 'KategoriController@index');
    Route::post('/kategori/add-kategori', 'KategoriController@store')->name('kategori');
    
    // siswa
    Route::get('/siswa', function () {
        $students = Students::all();
        return view('admin.students.index', compact('students'));
    });

    // comment article
    Route::post('/comment/{artikel}/add-comment', 'commentArticleController@store')->name('addComent');
});

// User
Route::get('/', function () {
    return view('user.index');
});
Route::get('/events', function () {
    return view('user.events');
});
Route::get('/ekskul', function () {
    return view('user.eskul');
});

Route::get('/tentang', function () {
    return view('user.tentang');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    '\vendor\uniSharp\LaravelFilemanager\Lfm::routes()';
});
