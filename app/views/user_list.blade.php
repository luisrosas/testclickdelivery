@extends('layouts.main')
@section('content')
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4>Lista de usuarios</h4>
		</div>

		<div class="panel-body table-responsive">
			@include('message')
			<table class="table">
				<thead>
					<tr>
						<th>Id</th>
						<th>Nombre</th>
						<th>Teléfono</th>
						<th>Correo</th>
						<th>Tipo</th>
						<th>Estado</th>
						<th width="120">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->id }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->phone }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ ($user->type == 1 ? 'Adminstrador' : ($user->type == 2 ? 'Agente' : 'Cliente')) }}</td>
							<td>{{ ($user->state == 1 ? 'Activo' : 'Inactivo') }}</td>
							<td align="right">
								@if($privileges['edit'])
								<a href="{{ URL::to('users/edit/'.$user->id) }}"><span class="label label-success">Editar</span></a>
								@endif
								@if($privileges['delete'])
								<a href="#" data-id="{{ $user->id }}" class="delete"><span class="label label-danger">Eliminar</span></a>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	@if(Session::has('message'))
		<div class="">{{ Session::get('message')}}</div>
	@endif

@stop