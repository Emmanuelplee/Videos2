<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;//para la base de datos
use Illuminate\Support\Facades\Storage;//nos permite subir archivos y guardalos en la carpeta storage
use Symfony\Component\HttpFoundation\Response;//para alguna respuesta

use App\User;//modelo de user
use App\Video; //modelo de video
use App\Comment;//modelo del comentario



class UserController extends Controller
{
    public function channel($user_id){
    	$user = User::find($user_id);

    	if(!is_object($user)){
    		return redirect()->route('home');
    	}

    	$videos = Video::where('user_id', $user_id)->paginate(5);

    	return view('user.channel', array(
    		'user' => $user,
    		'videos' => $videos
    	));

    }

}
