@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        

        <div class="container ">
			<div class="col-md-5 ">				
				<h2>Canal del Usuario: {{ $user->name.' '.$user->surname }}</h2>
			</div>
 
			<div class="clearfix"></div>
			<hr>

	        @include('video.videosList')
        </div>
     </div>
</div>
@endsection