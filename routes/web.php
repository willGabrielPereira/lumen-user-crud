<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'user'], function () use ($router) {


    $router->get('/', ['as' => 'user', 'uses' => 'UserController@index']);
    $router->get('/show/{user}', ['as' => 'user.show', 'uses' => 'UserController@show']);

    $router->post('/store', ['as' => 'user.store', 'uses' => 'UserController@store']);
    $router->put('update/{user}', ['as' => 'user.update', 'uses' => 'UserController@update']);
    $router->delete('/delete/{user}', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);
});


$router->get('/', function () {
    return view('home');
});
