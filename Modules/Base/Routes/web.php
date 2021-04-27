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

Route::group(['middleware' => ['auth']], function () {
    $this->get('/', 'Dashboard\DashboardController@index')->name('dashboard');
    $this->get('logout', 'Auth\LoginController@logout')->name('logout');

    //Users

    $this->get('user/create', 'UserController@create')->name('users.create');
    $this->post('user/store', 'UserController@store')->name('users.store');
    $this->get('user/list', 'UserController@list')->name('users.list');
    $this->get('user/edit/{user}', 'UserController@edit')->name('users.edit');
    $this->put('user/edit/{user}', 'UserController@update')->name('users.update');
    $this->get('user/delete/{id}', 'UserController@destroy')->name('users.delete');
    $this->get('user/assign/role', 'UserController@getAssignRole')->name('roles.user.assign');
    $this->post('user/{id}/assign/role', 'UserController@postAssignRole')->name('roles.user.assign.post');

    //Roles

    $this->get('role/create', 'RoleController@create')->name('roles.create');
    $this->post('role/store', 'RoleController@store')->name('roles.store');
    $this->get('role/list', 'RoleController@list')->name('roles.list');
    $this->get('role/edit/{role}', 'RoleController@edit')->name('roles.edit');
    $this->put('role/edit/{role}', 'RoleController@update')->name('roles.update');
    $this->get('role/delete/{id}', 'RoleController@destroy')->name('roles.delete');
    $this->get('role/hierarchy', 'RoleController@roleHierarchy')->name('roles.hierarchy');

    //Role groups

    $this->get('role/group/create', 'RoleGroupController@create')->name('roles.group.create');
    $this->post('role/group/store', 'RoleGroupController@store')->name('roles.group.store');
    $this->get('role/group/list', 'RoleGroupController@list')->name('roles.group.list');
    $this->get('role/group/edit/{roleGroup}', 'RoleGroupController@edit')->name('roles.group.edit');
    $this->put('role/group/edit/{roleGroup}', 'RoleGroupController@update')->name('roles.group.update');
    $this->get('role/group/delete/{id}', 'RoleGroupController@destroy')->name('roles.group.delete');

    //Settings

    //Language

    $this->get('language/create', 'LanguageController@create')->name('language.create');
    $this->post('language/store', 'LanguageController@store')->name('language.store');
    $this->get('language/manage', 'LanguageController@manageForm')->name('language.manage.get');
    $this->put('language/manage', 'LanguageController@manage')->name('language.manage.put');
    $this->get('language/list', 'LanguageController@list')->name('language.list');
    $this->get('language/edit/{language}', 'LanguageController@edit')->name('language.edit');
    $this->put('language/edit/{language}', 'LanguageController@update')->name('language.update');
    $this->get('language/delete/{id}', 'LanguageController@destroy')->name('language.delete');
});


$this->view('login', 'base::auth.login')->name('get.login');
$this->post('login', 'Auth\LoginController@login')->name('post.login');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');
