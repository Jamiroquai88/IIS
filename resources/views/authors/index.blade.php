@extends('layouts.default')

@section('content')
	<H1>Authors home page</H1>

	<ul>
	@foreach($authors as $author)
		<li>{{ $author->name }}</li>
	@endforeach
	</ul>
@endsection