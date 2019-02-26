<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;//para la base de datos
use Illuminate\Support\Facades\Storage;//nos permite subir archivos y guardalos en la carpeta storage
use Symfony\Component\HttpFoundation\Response;//para alguna respuesta

use App\Video; //modelo de video
use App\Comment;//modelo del comentario


class Video2Controller extends Controller
{
    public function update($video_id, Request $request ){
        //Vidacion del formulario
        $validatedData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);

        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de la minuatura o imagen
        $image = $request->file('image');//recoger el fichero en $image
        if($image){//si image llega es true
            $image_path = time().$image->getClientOriginalName();//coger le path de la image
            \Storage::disk('images')->put($image_path, \File::get($image));//guardar en images con disk por el metodo put

            //Eliminar fichero de image actual
            if ($video->image) { //Si model video de image es true entonces eliminar video iamge
            Storage::disk('images')->delete($video->image);
            }

            $video->image = $image_path;//pasamos el nombre que gusarda en el disco duro
        }
 

        //Subida del video
        $video_file = $request->file('video');
        if($video_file){
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));

            //Eliminamos ficheros de video
            if($video->video_path){
                \Storage::disk('videos')->delete($video->video_path); 
            }

            $video->video_path = $video_path;//ruta model y video_path de la base se la pase el archivo video_path
        }



        $video->update();

        return redirect()->route('home')->with(array(
                'message' => 'El video se ha actualizado correctamente!!'
        ));
    } 

    public function search($search = null, $filter = null){

        if (is_null($search)) {
            $search = \Request::get('search');

            return redirect()->route('searchVideo', array('search' => $search));

            if (is_null($search)) {                
                return redirect()->route('home');
            } 
            
        }

        if (is_null($filter) && \Request::get('filter') && !is_null($search)) {
            $filter = \Request::get('filter');

            return redirect()->route('searchVideo', array('search' => $search , 'filter' => $filter));
         } 
          
         $column = 'id';
         $order = 'desc';

        if(!is_null($filter)){

            if($filter == 'new'){
                $column = 'id';
                $order = 'desc';
            } 

            if($filter == 'old'){         
                $column = 'id';
                $order = 'asc';
            }

             if($filter == 'alfa'){
                $column = 'title';
                $order = 'asc';
            }

        }        

        $videos = Video::where('title','LIKE', '%'.$search.'%')
                              ->orderBy($column, $order)
                              ->paginate(5);

        return view('video.search', array(
            'videos' => $videos,
            'search' => $search
        ));
    }

}
