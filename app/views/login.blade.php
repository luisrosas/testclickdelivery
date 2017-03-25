@extends('layouts.main')
@section('content')

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="{{ URL::to('/') }}" class="btn-home">
					<i class="glyphicon glyphicon-home"></i>
				</a>
				<h4>Ingrese sus datos</h4>
			</div>
			<div class="panel-body">
				@include('message')
				{{ Form::open() }}
			
					<p>{{ Form::email('email','',['placeholder' => 'E-mail', 'class' => 'form-control']) }}</p>
					<p>{{ Form::password('password',['placeholder' => 'Contraseña', 'class' => 'form-control']) }}</p>
					<p>{{ Form::submit('Ingresar',['class' => 'btn btn-primary']) }} <span>O ingresa con: </span> <a href="{{ URL::to('login/fb') }}">{{ HTML::image('img/icon-fb.png','', ['class' => 'img-circle', 'width' => '40px']) }}</a></p>
				{{ Form::close()}}
			</div>
		</div>
	</div>

@stop