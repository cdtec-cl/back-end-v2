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
/* 
    $router->get($uri, $callback);
    $router->post($uri, $callback);
    $router->put($uri, $callback);
    $router->patch($uri, $callback);
    $router->delete($uri, $callback);
    $router->options($uri, $callback);

    $router->get('user/{id}', function ($id) {
        return 'User '.$id;
    });
    $router->get('posts/{postId}/comments/{commentId}', function ($postId, $commentId) {
        //
    });
*/

$router->post('farm/{id}', function ($id) {
    return 'Farm '.$id;
});

//RUTAS Definitivas
$router->post('/users/login', ['uses' => 'UsersController@getToken']);

$router->group(['middleware'=>['auth']], function() use($router){
    $router->post('/users', ['uses' => 'UsersController@index']);
    $router->get('/', [function () use ($router) {echo 'Getbase'; }] );
    $router->post('/', [function () use ($router) {echo 'Getbase'; }] );
    $router->post('user/profile',['uses' => 'UsersController@index']);
    $router->post('/users/create', ['uses' => 'UsersController@create']);
    $router->post('/farms', ['uses' => 'FarmsController@show']);

    $router->post('/accounts', ['uses' => 'AccountsController@show']);
    $router->post('/typezones', ['uses' => 'TypeZonesController@show']);
    $router->post('/zones', ['uses' => 'ZonesController@show']);
    /*
    $router->post('/farm/{id}', [
        'uses' => 'FarmController@show/{id}'
    ]);
    */
});
//APP KEY Generador
$router->post('/key-generate', function () use ($router) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 32);
});

