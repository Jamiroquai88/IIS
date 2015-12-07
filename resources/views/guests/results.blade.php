@extends('layouts.default')

@section('content')

		<h3>Search Results</h3>

			@if(!$searchresults)
				<div class="alert alert-info" role="alert">No Results</div>
			@else			
				<table class="table table-striped">
					<tr>
						<th>Name</th>
						<th>Address</th>
						<th>Birth date</th>
						<th>Telephone</th>
					</tr>
					@foreach($searchresults as $res)
	  					<tr>
							<td>{!! $res->Meno !!}</td>
							<td>{!! $res->Adresa !!}</td>
							<td>{!! $res->DatNar !!}</td>
							<td>{!! $res->TelCis !!}</td>
						</tr>
					@endforeach
				</table>
			@endif
@endsection