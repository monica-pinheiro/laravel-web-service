<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

/*Route::get('/categories', 'App\Http\Controllers\Api\CategoryController@index');
Route::post('/categories', 'App\Http\Controllers\Api\CategoryController@store');
Route::put('/categories/{id}', 'App\Http\Controllers\Api\CategoryController@update');
Route::delete('/categories/{id}', 'App\Http\Controllers\Api\CategoryController@delete');*/

//simplificado(todas em 1)
Route::resource('categories', CategoryController::class);
Route::get('/categories/{id}/products', 'App\Http\Controllers\Api\CategoryController@products');

Route::resource('products', ProductController::class);


