<?php

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

$app->get('/', function () use ($app) {
    return $app->version();
});

/**
 * Routes for resource fight-controller
 */
$app->get('fight-controller', 'FightControllersController@all');
$app->get('fight-controller/{id}', 'FightControllersController@get');
$app->post('fight-controller', 'FightControllersController@add');
$app->put('fight-controller/{id}', 'FightControllersController@put');
$app->delete('fight-controller/{id}', 'FightControllersController@remove');

/**
 * Routes for resource test
 */
$app->get('test', 'TestsController@all');
$app->get('test/{id}', 'TestsController@get');
$app->post('test', 'TestsController@add');
$app->put('test/{id}', 'TestsController@put');
$app->delete('test/{id}', 'TestsController@remove');

/**
 * Routes for resource example
 */
$app->get('example', 'Example@all');
$app->get('example/{id}', 'Example@get');
$app->post('example', 'Example@add');
$app->put('example/{id}', 'Example@put');
$app->delete('example/{id}', 'Example@remove');

/**
 * Routes for resource example-controller
 */
$app->get('example-controller', 'ExampleController@all');
$app->get('example-controller/{id}', 'ExampleController@get');
$app->post('example-controller', 'ExampleController@add');
$app->put('example-controller/{id}', 'ExampleController@put');
$app->delete('example-controller/{id}', 'ExampleController@remove');
