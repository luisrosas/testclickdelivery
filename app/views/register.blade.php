@extends('layouts.main')
@section('content')

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="{{ URL::to('/') }}" class="btn-home">
					<i class="glyphicon glyphicon-home"></i>
				</a>
				<h4>Registro</h4>
			</div>
			<div class="panel-body">
				@include('message')
				{{ Form::open() }}
					<p>{{ Form::text('name','',['placeholder' => 'Nombre', 'class' => 'form-control']) }}</p>
					<p>{{ Form::text('phone','',['placeholder' => 'Teléfono', 'class' => 'form-control']) }}</p>
					<p>{{ Form::email('email','',['placeholder' => 'E-mail', 'class' => 'form-control']) }}</p>
					<p>{{ Form::password('password',['placeholder' => 'Contraseña', 'class' => 'form-control']) }}</p>
					<p>{{ Form::password('password_r',['placeholder' => 'Confirmar contraseña', 'class' => 'form-control']) }}</p>
					<p>{{ Form::submit('Registrarse',['class' => 'btn btn-primary']) }} <span>O registrate con: </span> <a href="{{ URL::to('register/fb') }}">{{ HTML::image('img/icon-fb.png','', ['class' => 'img-circle', 'width' => '40px']) }}</a></p>
				{{ Form::close()}}
			</div>
		</div>
	</div>

@stop