@extends('layouts.main')
@section('content')

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	  			<h4>Editar Usuario</h4>
	  		</div>
	  		<div class="panel-body">
	  			@include('message')
	  			{{ Form::open(['method' => 'PUT']) }}
					<p>{{ Form::text('name', $user->name,['placeholder' => 'Nombre', 'class' => 'form-control']) }}</p>
					<p>{{ Form::text('phone', $user->phone,['placeholder' => 'Teléfono', 'class' => 'form-control']) }}</p>
					<p>{{ Form::email('email', $user->email,['placeholder' => 'E-mail', 'class' => 'form-control', 'disabled']) }}</p>					
					<p>{{ Form::password('password', ['placeholder' => 'Contraseña', 'class' => 'form-control']) }}</p>
					<p>{{ Form::password('password_r', ['placeholder' => 'Confirmar contraseña', 'class' => 'form-control']) }}</p>
					<p><h4>Permisos</h4></p>
					<p>{{ Form::checkbox('view', '1', $privileges['view'], '') }} Ver Lista de clientes</p>
					<p>{{ Form::checkbox('edit', '1', $privileges['edit'], '') }} Editar Lista de clientes</p>
					<p>{{ Form::checkbox('delete', '1', $privileges['delete'], '') }} Eliminar Lista de clientes</p>			
					<p>{{ Form::submit('Actualizar',['class' => 'btn btn-primary']) }}</p>
				{{ Form::close()}}
			</div>
		</div>		
	</div>

@stop