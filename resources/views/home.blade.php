@extends('layout.app')

@section('title', 'Home')

@section('content')

	<!-- view handling messages -->
	@include('errors.error')
	You are logged in!

@endsection
