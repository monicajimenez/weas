@extends("layouts/master") @section('sitetitle', 'Profile') @section('pagetitle', 'Profile') @section("content")
<div class="row">
	<div class="col s11 m10 right">
		<form>
			<!-- Basic Details -->
			<div class="row">
				<div class="col s10 m10">
					<h5>Basic Details:</h5>
				</div>
			</div>
			<div class="row">
				<div class="col s10 m5">
					<div class="row">
						<div class="input-field col s12">
							<input id="last_name" type="text" class="validate">
							<label for="last_name">Last Name</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input id="first_name" type="text" class="validate">
							<label for="first_name">First Name</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input disabled id="username" type="text" class="validate">
							<label for="username">Username</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input disabled id="email" type="text" class="validate">
							<label for="email">Email</label>
						</div>
					</div>
				</div>
				<div class="col s10 m5 padding-left-25 hide-on-small-only">
					<div class="row">
						<div class="input-field col s12">
							<input id="position" type="text" class="validate">
							<label for="position">Position</label>
						</div>
					</div>
					<div class="row">
						<div id="department" class="input-field col s12">
							<select>
								<option value="" disabled selected>Choose your Department</option>
								<option value="1">IT</option>
								<option value="2">Finance</option>
								<option value="3">HR</option>
							</select>
							<label>Department</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input disabled id="account_type" type="text" class="validate">
							<label for="account_type">Account Type</label>
						</div>
					</div>
				</div>
				<div class="col s10 m5 hide-on-med-and-up">
					<div class="row">
						<div class="input-field col s12">
							<input id="position" type="text" class="validate">
							<label for="position">Position</label>
						</div>
					</div>
					<div class="row">
						<div id="department" class="input-field col s12">
							<select>
								<option value="" disabled selected>Choose your Department</option>
								<option value="1">IT</option>
								<option value="2">Finance</option>
								<option value="3">HR</option>
							</select>
							<label>Department</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input disabled id="account_type" type="text" class="validate">
							<label for="account_type">Account Type</label>
						</div>
					</div>
				</div>
			</div>
			<!-- End: Basic Details -->
			<div class="row">
				<div class="col s12">
					<div class="divider">
					</div>
				</div>
			</div>
			<!-- Security Details -->
			<div class="row">
				<div class="col s10 m5">
					<h5>Security Details:</h5>
					<div class="row">
						<div class="input-field col s12">
							<input id="new_password" type="text" class="validate">
							<label for="new_password">New Password</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input id="confirm_password" type="text" class="validate">
							<label for="confirm_password">Confirm Password</label>
						</div>
					</div>
				</div>
			</div>
			<!-- End: Security Details -->
		</form>
		<!-- Buttons-->
		<div class="fixed-action-btn" style="bottom: 80px;">
			<a class="btn-floating btn-large green">
			<i class="large material-icons">perm_identity</i>
			</a>
		</div>
		<!-- End: Buttons-->
	</div>
</div>
@stop