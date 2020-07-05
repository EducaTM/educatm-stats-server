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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['register' => false]);



Route::middleware(['auth'])->group(function(){
    Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']); 
    Route::post('register', ['as' => '', 'uses' => 'Auth\RegisterController@register']);
    
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    Route::get('/clients', ['as' => 'clients', 'uses' => 'ClientsController@index']);
    Route::post('/clients', ['as' => 'create-client', 'uses' => 'ClientsController@create']);
    Route::get('/clients/{id}/edit', ['as' => 'edit-client', 'uses' => 'ClientsController@edit']);
    Route::put('/clients/{id}', ['as' => 'update-client', 'uses' => 'ClientsController@update']);
    
    Route::get('/users', ['as' => 'users', 'uses' => 'UsersController@index']);
    Route::get('/users/{id}/disable', ['as' => 'disable-user', 'uses' => 'UsersController@disable']);
    Route::get('/users/{id}/enable', ['as' => 'enable-user', 'uses' => 'UsersController@enable']);
    Route::get('/users/{id}/edit', ['as' => 'edit-user', 'uses' => 'UsersController@edit']);
    Route::put('/users/{id}', ['as' => 'update-user', 'uses' => 'UsersController@update']);

    
    
});


