@extends('layouts.default')

@section('content')

	<h2>Register</h2>
	@if($errors->has())
		<p>The following errors have occured:</p>

		<ul id="form-errors">
			{!! $errors->first('username','<li>:message</li>') !!}
			{!! $errors->first('password','<li>:message</li>') !!}
			{!! $errors->first('password_confirmation','<li>:message</li>') !!}
			{!! $errors->first('name','<li>:message</li>') !!}
			{!! $errors->first('birth_date','<li>:message</li>') !!}
			{!! $errors->first('address','<li>:message</li>') !!}
			{!! $errors->first('telephone','<li>:message</li>') !!}
			{!! $errors->first('mail','<li>:message</li>') !!}
		</ul>
	@endif

	{!! Form::open(['register', 'POST']) !!}

	{!! Form::token() !!}

	<p>
		{!! Form::label('username', 'Username *') !!}<br />
		{!! Form::text('username', Input::old('username')) !!}
	</p>

	<p>
		{!! Form::label('password', 'Password *') !!}<br />
		{!! Form::password('password') !!}
	</p>	

	<p>
		{!! Form::label('password_confirmation', 'Confirm Password *') !!}<br />
		{!! Form::password('password_confirmation') !!}
	</p>

	<p>
		{!! Form::label('name', 'Full name *') !!}<br />
		{!! Form::text('name', Input::old('name')) !!}
	</p>

	<p>
		{!! Form::label('address', 'Address') !!}<br />
		{!! Form::text('address', Input::old('address')) !!}
	</p>

	<p>
		{!! Form::label('birth_date', 'Date of birth') !!}<br />
		{!! Form::date('birth_date') !!}
	</p>	

	<p>
		{!! Form::label('telephone', 'Telephone Number') !!}<br />
		{!! Form::text('telephone', Input::old('telephone')) !!}
	</p>

	<p>
		{!! Form::label('mail', 'E-mail') !!}<br />
		{!! Form::text('mail', Input::old('mail')) !!}
	</p>

	<p>{!! Form::submit('Register') !!}</p>

	<h5>All fields with * are required.</h5>

	{!! Form::close() !!}

@endsection