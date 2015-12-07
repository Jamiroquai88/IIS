@extends('layouts.default')

@section('content')

	<h2>Add Guest</h2>
	@if($errors->has())
		<p>The following errors have occured:</p>

		<ul id="form-errors">
			{!! $errors->first('name','<li>:message</li>') !!}
			{!! $errors->first('guest_id','<li>:message</li>') !!}
			{!! $errors->first('birth_date','<li>:message</li>') !!}
			{!! $errors->first('address','<li>:message</li>') !!}
			{!! $errors->first('telephone','<li>:message</li>') !!}
			{!! $errors->first('mail','<li>:message</li>') !!}
			{!! $errors->first('message','<li>:message</li>') !!}
		</ul>
	@endif

	{!! Form::open(['addguest', 'POST']) !!}

	{!! Form::hidden('id', $id) !!}

	{!! Form::token() !!}

	<p>
		{!! Form::label('name', 'Full Name *') !!}<br />
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
		{!! Form::label('guest_id', 'Guest ID number *') !!}<br />
		{!! Form::text('guest_id',  Input::old('guest_id')) !!}
	</p>	

	<p>
		{!! Form::label('telephone', 'Telephone Number') !!}<br />
		{!! Form::text('telephone', Input::old('telephone')) !!}
	</p>

	<p>
		{!! Form::label('mail', 'E-mail') !!}<br />
		{!! Form::text('mail', Input::old('mail')) !!}
	</p>

	<p>{!! Form::submit('Accomodate') !!}</p>

	<h5>All fields with * are required.</h5>

	{!! Form::close() !!}

@endsection