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

Route::get('/', [
    'as' => 'accueil',
    'uses' => 'ControllerCRUD@accueil'
]);

Route::post('/supprimer', [
	'as' => 'ajaxSupprimer',
    'uses' => 'ControllerCRUD@ajaxSupprimer'
]);

Route::post('/ajouter', [
	'as' => 'ajaxAjouter',
    'uses' => 'ControllerCRUD@ajaxAjouter'
]);

Route::post('/modifier', [
	'as' => 'ajaxModifier',
    'uses' => 'ControllerCRUD@ajaxModifier'
]);