@extends('layouts.default')

@section('content')
<div id="ask">
	<h2>Edit Service</h2>

	@if(Auth::check())
		@if($errors->has())
			<p>The following errors have occured:</p>
			<ul id="form-errors">
				{!! $errors->first('name','<li>:message</li>') !!}
				{!! $errors->first('price','<li>:message</li>') !!}
		@endif

		{!! Form::open(['editservice', 'POST']) !!}
	
		{!! Form::hidden('id', $service->CisSluzby) !!}

		{!! Form::token() !!}
		
		<p>
			{!! Form::label('name', 'Service Name *') !!}<br />
			@if(!$old)
				{!! Form::text('name', $service->Nazov) !!}
			@else
				{!! Form::text('name', Input::old('name')) !!}
			@endif
		</p>

		<p>
			{!! Form::label('price', 'Price *') !!}<br />
			@if(!$old)
				{!! Form::number('price', $service->Cena) !!}
			@else
				{!! Form::number('price', Input::old('price')) !!}
			@endif
		</p>	

		<p>{!! Form::submit('Edit Service') !!}</p>

		{!! Form::close() !!}

		<h5>All fields with * are required.</h5>

	@endif

</div>
@endsection