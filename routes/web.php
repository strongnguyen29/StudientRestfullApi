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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/'], function () use ($router) {

    $router->get('students', ['uses' => 'StudentController@index', 'as' => 'students.index']);

    $router->get('students/{id}', ['uses' => 'StudentController@index', 'as' => 'students.read']);

    $router->post('students', ['uses' => 'StudentController@store', 'as' => 'students.store']);

    $router->put('students/{id}', ['uses' => 'StudentController@update', 'as' => 'students.update']);

    $router->delete('students/{id}', ['uses' => 'StudentController@delete', 'as' => 'students.delete']);

});