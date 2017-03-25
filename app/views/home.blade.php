@extends('layouts.main')
@section('content')

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4>Seleccione una opción</h4>
			</div>
			<div class="panel-body">
				<p>{{ HTML::link(URL::to('login'), 'Iniciar sesión', ['class' => 'btn-primary-custom btn btn-lg btn-block']) }}</p>
				<p></p>
				<p>{{ HTML::link(URL::to('register'), 'Registrarse', ['class' => 'btn-primary-custom btn btn-lg btn-block']) }}</p>
			</div>
		</div>
	</div>

@stop