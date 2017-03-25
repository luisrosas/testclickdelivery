@extends('layouts.main')
@section('content')

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	  			<h4>Crear Agente</h4>
	  		</div>
	  		<div class="panel-body">
	  			@include('message')
	  			{{ Form::open() }}
					<p>{{ Form::text('name','',['placeholder' => 'Nombre', 'class' => 'form-control']) }}</p>
					<p>{{ Form::text('phone','',['placeholder' => 'Teléfono', 'class' => 'form-control']) }}</p>
					<p>{{ Form::email('email','',['placeholder' => 'E-mail', 'class' => 'form-control']) }}</p>					
					<p>{{ Form::password('password',['placeholder' => 'Contraseña', 'class' => 'form-control']) }}</p>
					<p>{{ Form::password('password_r',['placeholder' => 'Confirmar contraseña', 'class' => 'form-control']) }}</p>
					<p><h4>Permisos</h4></p>
					<p>{{ Form::checkbox('view', '1', true, '') }} Ver Lista de clientes</p>
					<p>{{ Form::checkbox('edit', '1', false, '') }} Editar Lista de clientes</p>
					<p>{{ Form::checkbox('delete', '1', false, '') }} Eliminar Lista de clientes</p>			
					<p>{{ Form::submit('Crear',['class' => 'btn btn-primary']) }}</p>
				{{ Form::close()}}
			</div>
		</div>		
	</div>

@stop