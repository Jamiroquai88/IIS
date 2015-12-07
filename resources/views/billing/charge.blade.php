@extends('layouts.default')

@section('content')
<div id="ask">
	<h2>Charge</h2>

	@if(Auth::check())
		@if($errors->has())
			<p>The following errors have occured:</p>
			<ul id="form-errors">
				{!! $errors->first('service','<li>:message</li>') !!}
				{!! $errors->first('amount','<li>:message</li>') !!}
			</ul>
		@endif

		{!! Form::open(['charge', 'POST']) !!}
		{!! Form::hidden('id', $previous) !!}

		{!! Form::token() !!}
		
		<p>
			{!! Form::label('service', 'Service *') !!}<br />
			{!! Form::select('service', [null=>'Please Select'] + $services) !!}
		</p>

		<p>
			{!! Form::label('amount', 'Amount *') !!}<br />
			{!! Form::number('amount', '1') !!}
		</p>

		<p>{!! Form::submit('Charge') !!}</p>

		{!! Form::close() !!}

		<h5>All fields with * are required.</h5>
	@else
		<p>please login</p>
	@endif

</div>
@endsection