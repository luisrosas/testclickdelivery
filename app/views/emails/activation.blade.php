<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Activación de registro</title>
</head>
<body>
	<div>
		Hola, {{ $data['name'] }}<br>
		Activa tu cuenta haciendo clic en el siguiente enlace: <br>
		{{ HTML::link(URL::to('activation/'.$data['code']), URL::to('activation/'.$data['code'])) }}
	</div>
</body>
</html>