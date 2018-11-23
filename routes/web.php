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

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('domain::list');
    } elseif (auth()->guard('domain')->check()) {
        return redirect('/myDNS');
    }

    return redirect()->route('domain::list');
});

Auth::routes();

Route::group([
    'prefix' => 'ajax',
    'namespace' => 'Ajax',
    'as' => 'ajax::',
], function () {
    Route::group([
        'prefix' => 'domains',
        'as' => 'domain::',
    ], function () {
        Route::group([
            'prefix' => '{domain}',
        ], function () {
            Route::delete('/', ['as' => 'delete', 'uses' => 'DomainController@delete']);
            Route::post('dnsRecords', ['as' => 'storeDNSRecord', 'uses' => 'DomainController@storeDNSRecord']);
            Route::delete('dnsRecords/{record}', ['as' => 'deleteDNSRecord', 'uses' => 'DomainController@deleteDNSRecord']);
            Route::put('dnsRecords/{record}', ['as' => 'updateDNSRecord', 'uses' => 'DomainController@updateDNSRecord']);
            Route::post('password', ['as' => 'addPassword', 'uses' => 'DomainController@addPassword']);
            Route::delete('password', ['as' => 'removePassword', 'uses' => 'DomainController@removePassword']);
        });
    });
});

Route::group([
    'middleware' => 'auth',
], function () {
    Route::group([
        'prefix' => 'settings',
        'as' => 'settings::',
    ], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'SettingController@index']);
        Route::get('/general', ['as' => 'getGeneral', 'uses' => 'SettingController@getGeneral']);
        Route::post('/general', ['as' => 'postGeneral', 'uses' => 'SettingController@postGeneral']);
    });

    Route::group([
        'prefix' => 'domains',
        'as' => 'domain::',
    ], function () {
        Route::get('/', ['as' => 'list', 'uses' => 'DomainController@index']);
        Route::get('/add', ['as' => 'add', 'uses' => 'DomainController@add']);
        Route::post('/', ['as' => 'store', 'uses' => 'DomainController@store']);
        Route::get('/{domain}/dns', ['as' => 'dns', 'uses' => 'DomainController@dns']);
        Route::post('/{domain}/ns-record', ['as' => 'update-ns-record', 'uses' => 'DomainController@updateNSRecord']);
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'user::',
    ], function () {
        Route::get('/', ['as' => 'list', 'uses' => 'UserController@index']);
        Route::get('/add', ['as' => 'add', 'uses' => 'UserController@add']);
        Route::post('/', ['as' => 'store', 'uses' => 'UserController@store']);
        Route::get('{user}', ['as' => 'edit', 'uses' => 'UserController@edit']);
        Route::post('{user}', ['as' => 'update', 'uses' => 'UserController@update']);
        Route::delete('{user}', ['as' => 'delete', 'uses' => 'UserController@delete']);
    });

    Route::group([
        'prefix' => 'posts',
        'as' => 'post::',
    ], function () {
        Route::get('/', ['as' => 'list', 'uses' => 'PostController@index']);
        Route::get('/add', ['as' => 'add', 'uses' => 'PostController@add']);
        Route::post('/', ['as' => 'store', 'uses' => 'PostController@store']);
        Route::get('{post}', ['as' => 'edit', 'uses' => 'PostController@edit']);
        Route::post('{post}', ['as' => 'update', 'uses' => 'PostController@update']);
        Route::delete('{post}', ['as' => 'delete', 'uses' => 'PostController@delete']);
    });

    Route::get('help', ['as' => 'help', 'uses' => function () {
        $posts = \App\Model\Post::orderBy('order', 'asc')->get();

        return view('help', compact('posts'));
    }]);
});

// Authentication Routes...
$this->get('domain_login', 'Auth\DomainLoginController@showLoginForm');
$this->post('domain_login', 'Auth\DomainLoginController@login');
$this->post('domain_logout', 'Auth\DomainLoginController@logout');
Route::get('/myDNS', ['as' => 'my_dns', 'uses' => 'DomainController@dns2'])->middleware('auth:domain');

