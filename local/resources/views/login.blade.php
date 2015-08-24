@extends("layouts/master")
@section('sitetitle', 'Log In')
@section('pagetitle', 'Log In')
@section("content")
<div id="login" class="row">
	<div class="col s12 m11 right">
		<div class="row">
			<div class="col s12 m3 center-align">
				<div class="card medium">
				    <div class="card-image">
				      <img class="circle responsive-img" src="{{ asset('images/login.jpg') }}">
				    </div>
				    <div class="card-content">
				    	<div class="row">
		                  <div class="input-field col s10">
		                    <input id="username" type="text" class="validate">
		                    <label for="username">Username</label>
		                  </div>
		                </div>
				    	<div class="row">
		                  <div class="input-field col s10">
		                    <input id="password" type="password" class="validate">
		                    <label for="password">Password</label>
		                  </div>
		                </div>
				    </div>
				    <div class="card-action">
				      <a href="{{ route('dashboard') }}">Log In</a>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
