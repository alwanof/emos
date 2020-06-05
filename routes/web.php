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

Route::get('/', function (){
    echo "hello world";
})->name('route_start');
Route::get('/testo', function (){
    $img = imagecreate(500, 100);
    //$textbgcolor = imagecolorallocate($img, 0, 0, 0);
    $textcolor = imagecolorallocate($img, 0, 0, 0);
    $txt = 'murad';
    imagestring($img, 5, 5, 5, $txt, $textcolor);
    ob_start();
    imagepng($img);
    printf('<img src="data:image/png;base64,%s"/ width="100">', base64_encode(ob_get_clean()));
});
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/menu/{rest}/{table}', 'MenuController@index')->name('menu.index');
Route::get('/menu/{rest}/{table}', 'MenuController@index')->name('menu.index');
Route::get('/print/all/{user}', 'MenuController@print_all')->name('print.all');

Route::get('/language/{language}','LanguageController@index')->name('switcher')->where('language','[A-Za-z]+');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('lang/{locale}', 'HomeController@lang')->name('lang');
Route::get('/busy','StartController@tableIsBusy');

Route::prefix('admin')->group(function () {
    Route::get('/users', 'UserController@index')->name('users')->middleware('permission:access-users');
    Route::get('/roles', 'UserController@roles')->name('roles')->middleware('permission:access-roles');
    Route::get('/permissions', 'UserController@permissions')->name('permissions')->middleware('permission:access-permissions');
    Route::get('/profile/{user}', 'UserController@profile')->name('profile');
    Route::get('/me', 'UserController@me')->name('me');
    Route::get('/config', 'ConfigController@config')->name('config.index')->middleware('permission:access-configs');
    Route::get('/settings', 'ConfigController@settings')->name('config.settings');
    Route::get('/orders/new', 'OrderController@rightNow')->name('order.new');
    Route::get('/boards', 'BoardController@index')->name('boards.index');
    Route::get('/categories', 'CategoryController@index')->name('category.index');
    Route::get('/items', 'ItemController@index')->name('item.index');
    Route::get('/item/profile/{item}', 'ItemController@profile')->name('item.profile');
    Route::get('/print/qrcode/{board}', 'BoardController@print_qrcode')->name('boards.qrcode');
    Route::resource('/members', 'MemberController');


});

