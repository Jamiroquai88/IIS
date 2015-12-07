@extends('layouts.default')

@section('content')
<div id="ask">
	<h3>Check-out</h3>

	@if(Auth::check())
		<table class="table table-striped">
			<tr>
				<th>Name</th>
				<th>From</th>
				<th>To</th>
				<th>Nights</th>
				<th>Room</th>
				<th>To Pay</th>
			</tr>
			<tr>
			  	<td>{!! $info->name !!}</td>
			  	<td>{!! $info->from !!}</td>	
			  	<td>{!! $info->to !!}</td>	
			  	<td>{!! $info->nights !!}</td>
			  	<td>{!! $info->room !!}</td>	
			   	<td>{!! $info->pay !!}</td>
			</tr>

			
		</table>
		{!! Form::open(['checkout', 'POST']) !!}
		
			{!! Form::hidden('id', $previous) !!}
			{!! Form::hidden('payment', $info->pay) !!}

			{!! Form::token() !!}

			<p>{!! Form::submit('Confirm') !!}</p>

			{!! Form::close() !!}
	@endif

</div>
@endsection





							