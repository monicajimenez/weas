<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<!-- Add required jQuery files for Materialize to function -->
<script type="text/javascript" src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/init.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>

@if(strpos(Request::path(),'request/create/') !== false ||
	strpos(Request::path(),'request/edit/') !== false ||
	strpos(Request::path(),'request/update/') !== false )
	<script type="text/javascript" src="{{ asset('js/jquery-ui-1.11.4.js') }}"></script>
	<meta name="csrf-token" content="{!! csrf_token() !!}">
@endif

<!-- Add required CSS files for Materialize to function -->
<link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}" media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">