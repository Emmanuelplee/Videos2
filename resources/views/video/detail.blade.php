@extends('layouts.app')

@section('content')

<div class="col-md-10 col-md-offset-1">
		<h2>{{$video->title}}</h2>
		<hr>

		<div class="col-md-8 ">
			<!--video-->
			<video controls id="video-player" >
				<source src="{{route('fileVideo', ['filename'=>$video->video_path])}}"></source>
				Tu navegador no es compatible
			</video>
			<!--descripcion-->
			<div class="panel panel-default video-data">
				<div class="panel-heading">
					<div class="panel-title">
						<p>Subido por: 
							<strong><a href="{{ route('channelUser', ['user_id' => $video->user_id])}}"> 
													{{$video->user->name.' '.$video->user->surname}}
									</a>
							</strong>
						</p>
						<p>Creado: 
							<strong>{{\FormatTime::LongTimeFilter($video->created_at)}}</strong>
						</p>
						<p>Fecha de creacion: 
							<strong>{{$video->created_at}}</strong>
						</p>
					</div>					
				</div>
				<div class="panel-body">
					{{$video->description}}
				</div>
				
			</div>
			<!--Comentarios-->

			@include('video.comments')

			
		</div>
</div>

@endsection