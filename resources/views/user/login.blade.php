@extends("layouts/master")
@section('sitetitle', 'Log In')
@section('pagetitle', 'Log In')
@section("content")
<div id="login" class="row valign center-align">
	<div class="col s12 m11 ">
		<div class="row">
			<div class="col s12 m3 ">
				@if($errors->any())
			      @foreach($errors->all() as $error)
			        <p class="errors">{{$error}}</p>
			      @endforeach
			    @endif
				<form action="{{ route('user.login') }}" method="post">
    				<input type="hidden" name="_token" value="{{ csrf_token()}}"/>
					<div class="card medium">
					    <div class="card-image">
					      <img class="circle responsive-img" src="{{ asset('images/login.jpg') }}">
					    </div>
					    <div class="card-content">
					    	<div class="row section">
			                  <div class="input-field col s10">
			                    <input name="username" type="text" class="validate">
			                    <label for="username">Email</label>
			                  </div>
			                </div>
					    	<div class="row section">
			                  <div class="input-field col s10">
			                    <input name="password" type="password" class="validate">
			                    <label for="password">Password</label>
			                  </div>
			                </div>
					    </div>
					    <div class="card-action">
					    	<button type="submit" class="waves-effect waves-light btn">Log In</button>
					    	<input type="hidden" name="_token" value="{{{ csrf_token() }}}"></input>
					    </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
