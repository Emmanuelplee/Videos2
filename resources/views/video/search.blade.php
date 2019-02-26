@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        

        <div class="container ">
			<div class="col-md-5 ">				
				<h2>Busqueda: {{$search}}</h2>
			</div>
 			<div class="col-md-7 ">
				<form  class="col-md-4 pull-right " action="{{ url('buscar/'.$search)}}" method="get" >
					<label for="filter" >Ordenar</label>
					<div class="espacio-search">
						<select name="filter" class="espacio-search form-control" >
							<option value="new">Mas nuevo primero</option>
							<option value="old">Mas antiguos primero</option>
							<option value="alfa">de la A a la Z</option>
						</select>
					</div>
					<input type="submit" value="Ordenar" class="btn-filter btn btn-sm btn-primary" />
				</form>
			</div>

			<div class="clearfix"></div>
			<hr>

	        @include('video.videosList')
        </div>
     </div>
</div>
@endsection