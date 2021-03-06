<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showHome');

// Confide RESTful route
Route::get('user/confirm/{code}', 'UserController@getConfirm');
Route::get('user/reset/{token}', 'UserController@getReset');
Route::controller( 'user', 'UserController');

Route::resource('projects', 'ProjectsController');

//We want to nest the controller so we have routes like /projects/1/series/1/edit :
Route::resource('projects.series', 'ProjectsSeriesController');

//We want to nest the controller so we have routes like /projects/1/series/1/invoices/1/edit :
//"Create" and "Store" are going to be handled by InvoicesController, so it's easier to create invoices
Route::resource('projects.series.invoices', 'ProjectsSeriesInvoicesController',
 array('except' => array('create', 'store')));
Route::resource('invoices', 'InvoicesController',
                array('only' => array('create', 'store')));


