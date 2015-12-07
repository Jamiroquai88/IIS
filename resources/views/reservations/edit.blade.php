@extends('layouts.default')

@section('content')


		<h2>Edit reservation</h2>
		@if($errors->has())
			<p>The following errors have occured:</p>

			<ul id="form-errors">
				{!! $errors->first('date_from','<li>:message</li>') !!}
				{!! $errors->first('date_to','<li>:message</li>') !!}
				{!! $errors->first('persons_number','<li>:message</li>') !!}
				{!! $errors->first('room','<li>:message</li>') !!}
				{!! $errors->first('message','<li>:message</li>') !!}
			</ul>
		@endif

		{!! Form::open(['editreservation', 'POST']) !!}

		{!! Form::hidden('id', $previous->CisRezervace) !!}

		{!! Form::token() !!}
		
			<p>
				{!! Form::label('date_from', 'From *') !!}<br />
				@if(!$old)
					{!! Form::date('date_from', $previous->Datum) !!}
				@else
					{!! Form::date('date_from', \Carbon\Carbon::now()) !!}
				@endif
			</p>	

			<p>
				{!! Form::label('date_to', 'To *') !!}<br />
				@if(!$old)
					{!! Form::date('date_to', $previous->DatumDo) !!}
				@else
					{!! Form::date('date_to', \Carbon\Carbon::now()) !!}
				@endif
			</p>		

			<p>
				{!! Form::label('persons_number', 'Number of persons *') !!}<br />
				@if(!$old)
					{!! Form::number('persons_number', $previous->osob) !!}
				@else
					{!! Form::number('persons_number', '1') !!}
				@endif
			</p>

			<p>
				{!! Form::label('room', 'Room number(beds) *') !!}<br />
				@if(!$old)
					{!! Form::select('room', [$previous->CisPokoje => ($previous->CisPokoje . '(' . $previous->Posteli . ')')] + $allrooms) !!}
				@else
					{!! Form::select('room', $allrooms) !!}
				@endif
			</p>

			<p>{!! Form::submit('Edit Reservation') !!}</p>

			<h5>All fields with * are required.</h5>


		{!! Form::close() !!}

@endsection