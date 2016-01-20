<?php

use \Illuminate\Http\Request;
use App\Task;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    /**
     * ROUTE Facade che definisce le rote standard per flusso di autenticazione.
     * Richiama \Illuminate\Routing\Router::auth
     */
    Route::auth();


    Route::get('/home', function () {
        return view('home');
    });

    /**
     * Show Task Dashboard
     */
    Route::get('/tasks', 'TaskController@index');


    /**
     * Add New Task
     */
    Route::post('/task', 'TaskController@store');

    /**
     * Delete Task
     */
    Route::delete('/task/{task}', 'TaskController@delete');
});
