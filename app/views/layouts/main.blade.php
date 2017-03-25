<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/style.css') }}
	<title>Prueba - Click Delivery</title>
</head>
<body>
	<div class="container">
		@if(Auth::check())
		<h1>BIENVENID@ {{ Auth::user()->name }}</h1>
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="{{ (Request::segment(2) == '' ? 'active' : '') }}"><a href="{{ URL::to('users') }}">Listar usuarios</a></li>
						@if(Auth::user()->type == 1)
						<li class="{{ (Request::segment(2) == 'create-agente' ? 'active' : '') }}"><a href="{{ URL::to('users/create-agente') }}">Crear agente</a></li>
						@endif
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL::to('me/edit') }}">Editar perfil</a></li>
								@if(Auth::user()->facebookId == 0)
								<li><a style="display: inline-block; margin-right: 10px;" href="{{ URL::to('add-account/fb') }}">Vincular con Facebook</a> {{ HTML::image('img/icon-fb.png','', ['class' => 'img-circle', 'width' => '15px', 'style' => 'display: inline-block; float: right; top: -20px; position: relative; margin-right: 10px']) }}</li>
								@endif
								<li role="separator" class="divider"></li>
								<li><a href="{{ URL::to('logout') }}">Cerrar sesión</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		@endif
		<div class="col-md-12 top-m">
			@yield('content')
		</div>
	</div>
	{{ HTML::script('js/jquery.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}

	<script>
		$(".delete").on('click', function(){
			$control = $(this);
			$id = $control.data('id');
			
			$.ajax({
				method: "DELETE",
				url: "{{ URL::to('users') }}/"+$id
			})
			.done(function( data ) {
				console.log(data);
				if(data.state == true)
				{
					$control.parent().parent().fadeOut( "slow", function() {
						$control.parent().parent().remove();
					});
				}else{
					alert(data.message);
				}
			});

			return false;
		});
	</script>
</body>
</html>