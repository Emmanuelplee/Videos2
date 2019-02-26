<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
 //use App\Video;
Route::get('/', function () {
	/*$videos = Video::all();
	foreach ($videos as $video) {
		echo 'Name del user: '.$video->user->name.' ';
		echo 'Title del video: '.$video->title.' ';
		echo 'Email del usuario: '.$video->user->email.'<br>';
		foreach ($video->comments as $comment) {
			echo 'Soy un comentario: '.$comment->body;
		}
		echo "<hr/>";
	}
	die();*/
    return view('welcome');
});

Route::auth();

Route::get('/', array(
 	'as'=> 'home',
 	'uses'=> 'HomeController@index'
 )); 
/*--Rutas del controlador de videos--*/
 Route::get('/crear-video', array(
 	'as'=> 'createVideo',
 	'middleware' => 'auth',
 	'uses'=> 'VideoController@createVideo'
 )); 
 Route::post('/guardar-video', array(
 	'as'=> 'saveVideo',
 	'middleware' => 'auth',
 	'uses'=> 'VideoController@saveVideo'
 ));

 Route::get('/miniatura/{filename}', array(
 	'as' => 'imageVideo',
 	'uses' => 'VideoController@getImage'
 ));
 Route::get('/video/{video_id}', array(
 	'as' => 'detailVideo',
 	'uses' => 'VideoController@getVideoDetail'
 ));
 Route::get('/video-file/{filename}', array(
 	'as' => 'fileVideo',
 	'uses' => 'VideoController@getVideo'
 ));
 
 Route::get('/delete-video/{video_id}', array(
 	'as' => 'videoDelete',
 	'middleware' => 'auth',
 	'uses' => 'VideoController@delete'
 )); 
 
 Route::get('/edit-video/{video_id}', array(
 	'as' => 'videoEdit',
 	'middleware' => 'auth',
 	'uses' => 'VideoController@editVideo'
 ));

 /*--Ruta de video2controller--*/ 
  Route::post('/update-video/{video_id}', array(
 	'as'=> 'updateVideo',
 	'middleware' => 'auth',
 	'uses'=> 'Video2Controller@update'
 ));
		//Ruta para el buscador
 Route::get('/buscar/{search?}/{filter?}', array(
 	'as' => 'searchVideo',
 	'uses' => 'Video2Controller@search'
 ));

 /*--Rutas del controlador de comentarios--*/
 Route::post('/comment', array(
 	'as' => 'comment',
 	'middleware' => 'auth',
 	'uses' => 'CommentController@store'
 )); 

Route::get('/delete-comment/{comment_id}', array(
 	'as' => 'commentDelete',
 	'middleware' => 'auth',
 	'uses' => 'CommentController@deleteComment'
 ));


 /*--Ruta para borra la cache de laravel--*/
 Route::get('/clear-cache', function(){
 	$code = Artisan::call('cache:clear');
 });

 /*--Ruta del coontrolador de canal--*/
 Route::get('/canal/{user_id}', array(
 	'as' => 'channelUser',
 	'uses' => 'UserController@channel'
 ));