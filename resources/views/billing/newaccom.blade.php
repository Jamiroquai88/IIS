@extends('layouts.default')

@section('content')

	<h2>Accomodate guest</h2>
	@if($errors->has())
		<p>The following errors have occured:</p>

		<ul id="form-errors">
			{!! $errors->first('name','<li>:message</li>') !!}
			{!! $errors->first('guest_id','<li>:message</li>') !!}
			{!! $errors->first('date_to','<li>:message</li>') !!}
			{!! $errors->first('birth_date','<li>:message</li>') !!}
			{!! $errors->first('address','<li>:message</li>') !!}
			{!! $errors->first('telephone','<li>:message</li>') !!}
			{!! $errors->first('mail','<li>:message</li>') !!}
			{!! $errors->first('room','<li>:message</li>') !!}
			{!! $errors->first('persons_number','<li>:message</li>') !!}
			{!! $errors->first('message','<li>:message</li>') !!}
		</ul>
	@endif

	{!! Form::open(['accomguest', 'POST']) !!}

	{!! Form::token() !!}

	<p>
		{!! Form::label('name', 'Full Name *') !!}<br />
		{!! Form::text('name', Input::old('name')) !!}
	</p>

	<p>
		{!! Form::label('persons_number', 'Number of persons *') !!}<br />
		{!! Form::number('persons_number', '1') !!}
	</p>

	<p>
		{!! Form::label('date_to', 'Date To *') !!}<br />
		{!! Form::date('date_to', \Carbon\Carbon::now()) !!}
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

	<p>
		{!! Form::label('room', 'Room number *') !!}<br />
		{!! Form::select('room', [null=>'Please Select'] + $allrooms) !!}
	</p>

	<p>{!! Form::submit('Accomodate') !!}</p>

	<h5>All fields with * are required.</h5>

	{!! Form::close() !!}

@endsection