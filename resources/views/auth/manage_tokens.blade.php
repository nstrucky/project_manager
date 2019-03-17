@extends('layouts.app')


@section('content')

<div style="margin: auto; padding: 50px;">
	<passport-clients></passport-clients>
</div>

<div >
	<passport-authorized-clients></passport-authorized-clients>
</div>

{{-- <div>
	<passport-personal-access-tokens></passport-personal-access-tokens>
</div> --}}

	
	
	

@endsection

@section('javascript')
{{-- This has a conflict with other javascript causing dropdown menu not to work --}}
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>

@endsection