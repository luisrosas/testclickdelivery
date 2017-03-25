@if($errors->any())
	<div class="alert {{ $errors->first('type') }} alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		{{ $errors->first('message') }}
	</div>
@endif