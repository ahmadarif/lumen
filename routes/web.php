<?php

use Illuminate\Http\Request;

$app->get('/', function () {
    $res['success'] = true;
    $res['result'] = "Hello there welcome to web api using lumen tutorial!";
    return response($res);
});

$app->post('/login', 'UserController@login');
$app->post('/register', 'UserController@register');

$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get('/user/{id}', 'UserController@getUser');
    $app->get('/user', function (Request $request) {
        $res['success'] = true;
        $res['data'] = $request->user();
        return response($res);
    });
});