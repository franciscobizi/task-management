<?php
/*
 * Here we have to registe routes
 * The routes receive two parametrs URL and Controllers with their methos
 * e.g Route::post('about','AboutController@about') 
*/
use FB\src\Route;

// Front routes
Route::post('', 'HomeController@index');
Route::post('create', 'HomeController@addTask');
Route::post('paginate', 'HomeController@paginate');

// Admin routes
Route::post('admin', 'AdminController@index');
Route::post('authentication', 'AdminController@auth');
Route::post('status', 'AdminController@status');
Route::post('edit-task', 'AdminController@editTask');
Route::post('user-profile', 'AdminController@userAccount');
Route::post('logout', 'AdminController@userLogOut');
