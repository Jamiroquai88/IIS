@extends('layouts.default')

@section('content')

	<h2>Edit account</h2>
	@if($errors->has())
		<p>The following errors have occured:</p>

		<ul id="form-errors">
			{!! $errors->first('address','<li>:message</li>') !!}
			{!! $errors->first('telephone','<li>:message</li>') !!}
			{!! $errors->first('mail','<li>:message</li>') !!}
		</ul>
	@endif

	{!! Form::open(['register', 'POST']) !!}

	{!! Form::hidden('id', $previous->id) !!}

	{!! Form::token() !!}

	@if($previous && $previous->username == 'admin')
		<br><br><h2>You little rebel! I like U!</h2>
	@else
		<p>
			{!! Form::label('address', 'Address') !!}<br />
			@if(!$old)
				{!! Form::text('address', $previous->address) !!}
			@else
				{!! Form::text('address', Input::old('address')) !!}
			@endif
		</p>

		<p>
			{!! Form::label('telephone', 'Telephone Number') !!}<br />
			@if(!$old)
				{!! Form::text('telephone', $previous->telephone) !!}
			@else
				{!! Form::text('telephone', Input::old('telephone')) !!}
			@endif
		</p>

		<p>
			{!! Form::label('mail', 'E-mail') !!}<br />
			@if(!$old)
				{!! Form::text('mail', $previous->mail) !!}
			@else
				{!! Form::text('mail', Input::old('mail')) !!}
			@endif
		</p>

		<p>{!! Form::submit('Edit Account') !!}</p>
	@endif

	{!! Form::close() !!}

@endsection