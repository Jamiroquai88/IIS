@extends('layouts.default')

@section('content')
<div id="ask">
	<h2>New Service</h2>

	@if(Auth::check())
		@if($errors->has())
			<p>The following errors have occured:</p>
			<ul id="form-errors">
				{!! $errors->first('name','<li>:message</li>') !!}
				{!! $errors->first('price','<li>:message</li>') !!}
		@endif

		{!! Form::open(['newservice', 'POST']) !!}
		
		{!! Form::token() !!}
		
		<p>
			{!! Form::label('name', 'Service Name *') !!}<br />	
			{!! Form::text('name', Input::old('name')) !!}
			
		</p>

		<p>
			{!! Form::label('price', 'Price *') !!}<br />
			{!! Form::number('price', Input::old('price')) !!}
		</p>	

		<p>{!! Form::submit('Create a service') !!}</p>

		{!! Form::close() !!}

		<h5>All fields with * are required.</h5>

	@endif

</div>
@endsection