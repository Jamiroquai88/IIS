@extends('layouts.default')

@section('content')
<div id="ask">
	<h2>Create reservation</h2>

	@if(Auth::check())
		@if($errors->has())
			<p>The following errors have occured:</p>
			<ul id="form-errors">
				{!! $errors->first('name','<li>:message</li>') !!}
				{!! $errors->first('date_from','<li>:message</li>') !!}
				{!! $errors->first('date_to','<li>:message</li>') !!}
				{!! $errors->first('persons_number','<li>:message</li>') !!}
				{!! $errors->first('user_id','<li>:message</li>') !!}
				{!! $errors->first('address','<li>:message</li>') !!}
				{!! $errors->first('birth_date','<li>:message</li>') !!}
				{!! $errors->first('telephone','<li>:message</li>') !!}
				{!! $errors->first('mail','<li>:message</li>') !!}
				{!! $errors->first('message','<li>:message</li>') !!}
				{!! $errors->first('room','<li>:message</li>') !!}
			</ul>
		@endif

		{!! Form::open(['createreservation', 'POST']) !!}

		{!! Form::token() !!}
		
		<p>
			{!! Form::label('name', 'Guest Name *') !!}<br />
			{!! Form::text('name', Input::old('name')) !!}
		</p>

		<p>
			{!! Form::label('date_from', 'From *') !!}<br />
			{!! Form::date('date_from', \Carbon\Carbon::now()) !!}
		</p>	

		<p>
			{!! Form::label('date_to', 'To *') !!}<br />
			{!! Form::date('date_to', \Carbon\Carbon::now()) !!}
		</p>	

		<p>
			{!! Form::label('persons_number', 'Number of persons *') !!}<br />
			{!! Form::number('persons_number', '1') !!}
		</p>

		<p>
			{!! Form::label('user_id', 'Guest ID Number *') !!}<br />
			{!! Form::text('user_id', Input::old('user_id')) !!}
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

		<p>
			{!! Form::label('room', 'Room number *') !!}<br />
			{!! Form::select('room', [null=>'Please Select'] + $allrooms) !!}
		</p>

		<p>{!! Form::submit('Create a reservation') !!}</p>

		{!! Form::close() !!}

		<h5>All fields with * are required.</h5>
	@else
		<p>please login</p>
	@endif

</div>
@endsection