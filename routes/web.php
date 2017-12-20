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

Route::get('/', 'TestController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/products/{id}', 'ProductController@show'); // ver producto

Route::get('/categories/{category}', 'CategoryController@show'); // ver categoría

Route::get('/search', 'SearchController@show');

Route::post('/cart', 'CartDetailController@store'); // crear carrito
Route::delete('/cart', 'CartDetailController@destroy'); // eliminar producto del carrito

Route::post('/order', 'CartController@update'); // realizar el pedido del carrito

// ADMIN PANEL
Route::middleware(['auth', 'admin'])->prefix('admin')->namespace('Admin')->group(function () {
	// listado
	Route::get('/products', 'ProductController@index'); // listado de productos

	// Registro
	Route::get('/products/create', 'ProductController@create'); // formulario de crear producto
	Route::post('/products', 'ProductController@store'); // guardar un producto

	// Edición
	Route::get('/products/{id}/edit', 'ProductController@edit'); // formulario de edición de producto
	Route::post('/products/{id}/edit', 'ProductController@update'); // actualizar datos de producto

	// Imágenes
	Route::get('/products/{id}/images', 'ImageController@index'); // mostrar imagen
	Route::post('/products/{id}/images', 'ImageController@store'); // guardar imagen
	Route::delete('/products/{id}/images', 'ImageController@destroy'); // eliminar imagen
	Route::get('/products/{id}/images/select/{image}', 'ImageController@select'); // destacar imagen

	// Eliminación
	Route::delete('/products/{id}', 'Admin\ProductController@destroy'); // eliminar producto

	// Categorías
	Route::get('/categories', 'CategoryController@index');
	Route::get('/categories/create', 'CategoryController@create');
	Route::post('/categories', 'CategoryController@store');
	// Otra forma de editar
	Route::get('/categories/{category}/edit', 'CategoryController@edit');
	Route::post('/categories/{category}/edit', 'CategoryController@update');
	Route::delete('/categories/{category}', 'CategoryController@destroy');
});

