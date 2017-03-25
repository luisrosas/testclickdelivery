@extends('layouts.main')
@section('content')

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4>Editar perfil</h4>
			</div>
			<div class="panel-body">
				@include('message')
				{{ Form::open(['method' => 'PUT']) }}
					<p>{{ Form::text('name', $me->name, ['placeholder' => 'Nombre', 'class' => 'form-control']) }}</p>
					<p>{{ Form::text('phone', $me->phone, ['placeholder' => 'Teléfono', 'class' => 'form-control']) }}</p>
					<p>{{ Form::email('email', $me->email, ['placeholder' => 'E-mail', 'class' => 'form-control', 'disabled']) }}</p>
					<p></p>
					<p>{{ Form::password('password',['placeholder' => 'Contraseña', 'class' => 'form-control']) }}</p>
					<p>{{ Form::password('password_r',['placeholder' => 'Confirmar contraseña', 'class' => 'form-control']) }}</p>
					<p>{{ Form::submit('Guardar',['class' => 'btn btn-primary']) }}</p>
				{{ Form::close()}}
			</div>
		</div>
	</div>

@stop