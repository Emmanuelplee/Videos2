            <div id="video-list">

                @if(count($videos) >= 1)
                @foreach($videos as $video)
                    <div class="video-item col-md-12 pull-left panel panel-default">
                       <div class="panel-body">
                            <!--Imanegen del video-->
                            @if(Storage::disk('images')->has($video->image))
                                <div class="video-image-thumb col-md-3 pull-left">
                                    <div class="video-image-mask">
                                        <!--<img src="{{url('/miniatura/'.$video->image)}}" class="video-image" />--> 
                                            <img src="{{route('imageVideo', ['filename'=>$video->image])}}" class="video-image" />
                                    </div>                            
                                </div>
                            @endif



                            <div class="data ">
                                <h4 class="video-title">
                                    <a href="{{route('detailVideo', ['video_id' => $video->id])}}">Titulo: {{$video->title}}</a>
                                </h4>                                
                                    <p> Usuario: <a href="{{ route('channelUser', ['user_id' => $video->user_id])}}"> 
                                            {{$video->user->name.' '.$video->user->surname}}
                                        </a> 
                                    </p>
                                    <p>Creado: 
                                        <strong>{{\FormatTime::LongTimeFilter($video->created_at)}}</strong>                                        
                                    </p>
                            </div>

                            <!--Botones de accion-->

                            <a href="{{route('detailVideo', ['video_id' => $video->id])}}" class="btn btn-success">Ver</a>  
                            @if(Auth::check() && Auth::user()->id == $video->user->id)
                                <a href="{{route('videoEdit', ['video_id' => $video->id])}}" class="btn btn-warning">Editar</a>  
                               <!-- <a href="" class="btn btn-danger">Eliminar</a>-->

                                    <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                    <a href="#victorModal{{$video->id}}" role="button" class="btn btn-danger" data-toggle="modal">Eliminar</a>   

                                    <!-- Modal / Ventana / Overlay en HTML -->
                                    <div id="victorModal{{$video->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">¿Estás seguro?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Seguro que quieres borrar este video?</p>
                                                    <p class="text-warning"><small>Video: {{$video->title}}</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    <a href="{{ route('videoDelete', ['video_id'=> $video->id])}}" type="button" class="btn btn-danger">Eliminar</a>
                                                    {{--<a href="{{url('delete-comment'.$comment->id)}}" type="button" class="btn btn-danger">Eliminar</a>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>                   

                            @endif
                            
                       </div>
                    </div>
                @endforeach
                @else
                    <div class="alert alert-warning"> No hay videos actualmente!!</div>
                @endif
                {{$videos->links()}} <!--navegacion de paginacion de bootstrap-->
            </div>