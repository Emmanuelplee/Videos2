<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;//para la base de datos
use Illuminate\Support\Facades\Storage;//nos permite subir archivos y guardalos en la carpeta storage
use Symfony\Component\HttpFoundation\Response;//para alguna respuesta

use App\Video; //modelo de video
use App\Comment;//modelo del comentario

class VideoController extends Controller
{
    public function createVideo(){
    	return view('video.createVideo');
    }

    public function saveVideo(Request $request){
        //Validar Formulario
    	$validatedData = $this->validate($request, [
    		'title' => 'required|min:5',
    		'description' => 'required',
    		'video' => 'mimes:mp4'
    	]);

    	$video = new Video();
    	$user = \Auth::user();
    	$video->user_id=$user->id;
    	$video->title = $request->input('title');
    	$video->description = $request->input('description');

    	//Subida de la minuatura o imagen
    	$image = $request->file('image');//recoger el fichero en $image
    	if($image){//si image llega es true
    		$image_path = time().$image->getClientOriginalName();//coger le path de la image
    		\Storage::disk('images')->put($image_path, \File::get($image));//guardar en images con disk por el metodo put
    		$video->image = $image_path;//pasamos el nombre que gusarda en el disco duro
    	}

    	//Subida del video
    	$video_file = $request->file('video');
    	if($video_file){
    		$video_path = time().$video_file->getClientOriginalName();
    		\Storage::disk('videos')->put($video_path, \File::get($video_file));

    		$video->video_path = $video_path;
    		//ruta model y video_path de la base se la pase el archivo video_path

    	}
		
    	$video->save();

    	return redirect()->route('home')->with(array(
    			'message' => 'El video se ha subido correctamente!!'
    	));
    }

    public function getImage($filename){
        $file = \Storage::disk('images')->get($filename); // images ruta declarada en config/filesystems.php
        return new Response($file, 200);
    }

    public function getVideoDetail($video_id){
        $video = Video::find($video_id);//usando eloquent para sacar un solo registro
        return view('video.detail', array(
            'video' => $video
        ));
    }

    public function getVideo($filename){
        $file = \Storage::disk('videos')->get($filename);// videos ruta declarada en config/filesystems.php
        return new Response($file, 200);
    }

    public function editVideo($video_id){
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);

        if ($user && $video->user_id == $user->id) {
            return view('video.edit', array('video' => $video));
        }
        else{            
            return redirect()->route('home');
        }

    }

    public function delete($video_id){
        $user = \Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();

        if ($user && $video->user_id == $user->id) {            
            //Eliminamos comentarios
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            } 
            

            //Eliminamos ficheros imagen y video tanto de base como local
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);

            //Eliminamos el registro
            $video->delete();

            $message = array('message' => 'Video eliminado correctamente!!');
        }
        else{
            $message = array('message' => 'EL VIDEO NO SE A ELIMINADO!!');
        } 
        
        return redirect()->route('home')->with($message);
    }

    
}
