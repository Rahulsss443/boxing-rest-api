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

 $app->group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('fight/create', 'FightController@create');
    $app->get('fight/all', 'FightController@all');
    $app->get('fight/make_prediction', 'FightController@makePrediction');
    $app->get('fight/getPredictions', 'FightController@getPredictions');

    $app->get('/', function () use ($app) {
            return $app->version();
    });
    $app->get('/foo', function(){
        
    });
   
});
