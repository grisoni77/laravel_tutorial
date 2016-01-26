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

Route::get('/', 'HomeController@index');



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

    /**
     * Homepage area protetta
     */
    Route::get('/home', 'HomeController@home');

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

    // EXPLICIT BINDING per recuperare i models soft deleted
    Route::bind('deletedTask', function($task) {
        return Task::withTrashed()->findOrFail($task);
    });

    /**
     * HARD Delete Task
     */
    Route::delete('/task/{deletedTask}/hard', 'TaskController@hardDelete')->name('hard-delete');
    /**
     * Restore Task
     */
    Route::post('/task/{deletedTask}/restore', 'TaskController@restore')->name('restore');

    /**
     * Generate PDF Task
     */
    Route::get('/task/pdf/{task}', 'TaskController@taskToPDF');
});

//Route::get('/api/test', function() {
//    return response()->json(['success'=>true])->header('Access-Control-Allow-Origin', 'http://www.consiglioregionale.piemonte.it');
//});
Route::resource('api/task', 'TaskRestController');
