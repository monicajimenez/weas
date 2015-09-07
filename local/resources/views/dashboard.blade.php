@extends("layouts/master")
@section('sitetitle', 'Dashboard')
@section('pagetitle', 'Dashboard')
@section("content")
<div class="row">
	<div class="col s12 m12">
		<!-- Requests Statistics -->
		<div class="row">
			<div class="col s12 m10 right">
				<div id="card-stats">
				    <div class="row">
				        <div class="col s12 m6 l3">
				            <div class="card">
				                <div class="card-content  yellow white-text">
				                    <p class="card-stats-title"><i class="material-icons left">thumbs_up_down</i>Pending Requests</p>
				                    <h4 class="card-stats-number center-align">10</h4>
				                    <!-- <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> 15% <span class="green-text text-lighten-5">from yesterday</span> 
				                    </p>-->
				                </div>
				                <div class="card-action  yellow darken-2">
				                    <div id="clients-bar"><canvas width="290" height="25" style="display: inline-block; width: 290px; height: 25px; vertical-align: top;"></canvas></div>
				                </div>
				            </div>
				        </div>
				        <div class="col s12 m6 l3">
				            <div class="card">
				                <div class="card-content purple white-text">
				                    <p class="card-stats-title"><i class="material-icons left">view_list</i>All Requests</p>
				                    <h4 class="card-stats-number center-align">1000</h4>
				                    <!-- <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> 70% <span class="purple-text text-lighten-5">last month</span>
				                    </p> -->
				                </div>
				                <div class="card-action purple darken-2">
				                    <div id="sales-compositebar"><canvas width="286" height="25" style="display: inline-block; width: 286px; height: 25px; vertical-align: top;"></canvas></div>

				                </div>
				            </div>
				        </div>                            
				        <div class="col s12 m6 l3">
				            <div class="card">
				                <div class="card-content green white-text">
				                    <p class="card-stats-title"><i class="material-icons left">thumb_up</i>Approved Requests</p>
				                    <h4 class="card-stats-number center-align">700</h4>
				                    <!-- <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> 80% <span class="blue-grey-text text-lighten-5">from yesterday</span>
				                    </p> -->
				                </div>
				                <div class="card-action green darken-2">
				                    <div id="profit-tristate"><canvas width="290" height="25" style="display: inline-block; width: 290px; height: 25px; vertical-align: top;"></canvas></div>
				                </div>
				            </div>
				        </div>
				        <div class="col s12 m6 l3">
				            <div class="card">
				                <div class="card-content red white-text">
				                    <p class="card-stats-title"><i class="material-icons left">thumb_down</i>Denied Requests</p>
				                    <h4 class="card-stats-number center-align">300</h4>
				                    <!-- <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-down"></i> 3% <span class="deep-purple-text text-lighten-5">from last month</span>
				                    </p> -->
				                </div>
				                <div class="card-action red darken-2">
				                    <div id="invoice-line">
				                    	<canvas width="223" height="25" style="display: inline-block; width: 223px; height: 25px; vertical-align: top;">
				                    		View Requests
				                    	</canvas>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
		</div>
		<!-- End: Requests Statistics -->
		
		<!-- Requests Table Container -->
		<!-- Table Label -->
		<div class="row">
			<div class="col s11 m10 right">
				<h5 class="left-align">Pending Requests</h5>
			</div>
		</div>
		<!-- End: Table Label -->
		
		<!-- Search Field -->
		<div class="row">
			<div class="col s12 m3 right">
				<form>
					<div class="input-field">
						<input type="search" id="search-field" class="field" required maxlength="">
						<label for="search-field"><i class="mdi-action-search"></i></label>
						<i class="mdi-navigation-close close"></i>
					</div>
				</form>
			</div>
		</div>
		<!-- End: Search Field -->

		<!-- Request Table -->
		<div class="row">
			<div class="col s12 m10 right">
				<table class="responsive-table hoverable">
					<thead class="">
						<tr>
							<th data-field="code" class="center-align">
								 Code
							</th>
							<th data-field="owners_name" class="center-align">
								 Owner's Name
							</th>
							<th data-field="project_name" class="center-align">
								 Project Name
							</th>
							<th data-field="lot_code" class="center-align">
								 Lot Code
							</th>
							<th data-field="request_type" class="center-align">
								 Request Type
							</th>
							<th data-field="payment_scheme" class="center-align">
								 Payment Scheme
							</th>
							<th data-field="qualification_date" class="center-align">
								 Qualification Date
							</th>
							<th data-field="date_filed" class="center-align">
								 Date Filed
							</th>
							<th data-field="actions" class="center-align">
								 Actions
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								 QAC-163
							</td>
							<td>
								 Melvin Lopez Baldonasa
							</td>
							<td>
								 RIVERSIDE2
							</td>
							<td>
								 AJ240
							</td>
							<td>
								 Qualified Accounts for Construction
							</td>
							<td>
								 20% over 18, 80% spot or bank
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								<a href="{{ route('request.show') }}">View</a><a  class="modal-trigger" href="#modal_action">Approve</a><a class="modal-trigger" href="#modal_action">Hold</a><a class="modal-trigger" href="#modal_action">Deny</a>
							</td>
						</tr>
						<tr>
							<td>
								 QAC-163
							</td>
							<td>
								 Melvin Lopez Baldonasa
							</td>
							<td>
								 RIVERSIDE2
							</td>
							<td>
								 AJ240
							</td>
							<td>
								 Qualified Accounts for Construction
							</td>
							<td>
								 20% over 18, 80% spot or bank
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								<a href="{{ route('request.show') }}">View</a><a  class="modal-trigger" href="#modal_action">Approve</a><a class="modal-trigger" href="#modal_action">Hold</a><a class="modal-trigger" href="#modal_action">Deny</a>
							</td>
						</tr>
						<tr>
							<td>
								 QAC-163
							</td>
							<td>
								 Melvin Lopez Baldonasa
							</td>
							<td>
								 RIVERSIDE2
							</td>
							<td>
								 AJ240
							</td>
							<td>
								 Qualified Accounts for Construction
							</td>
							<td>
								 20% over 18, 80% spot or bank
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								<a href="{{ route('request.show') }}">View</a><a  class="modal-trigger" href="#modal_action">Approve</a><a class="modal-trigger" href="#modal_action">Hold</a><a class="modal-trigger" href="#modal_action">Deny</a>
							</td>
						</tr>
						<tr>
							<td>
								 QAC-163
							</td>
							<td>
								 Melvin Lopez Baldonasa
							</td>
							<td>
								 RIVERSIDE2
							</td>
							<td>
								 AJ240
							</td>
							<td>
								 Qualified Accounts for Construction
							</td>
							<td>
								 20% over 18, 80% spot or bank
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								<a href="{{ route('request.show') }}">View</a><a  class="modal-trigger" href="#modal_action">Approve</a><a class="modal-trigger" href="#modal_action">Hold</a><a class="modal-trigger" href="#modal_action">Deny</a>
							</td>
						</tr>
						<tr>
							<td>
								 QAC-163
							</td>
							<td>
								 Melvin Lopez Baldonasa
							</td>
							<td>
								 RIVERSIDE2
							</td>
							<td>
								 AJ240
							</td>
							<td>
								 Qualified Accounts for Construction
							</td>
							<td>
								 20% over 18, 80% spot or bank
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								 April 12, 2012
							</td>
							<td>
								<a href="{{ route('request.show') }}">View</a><a  class="modal-trigger" href="#modal_action">Approve</a><a class="modal-trigger" href="#modal_action">Hold</a><a class="modal-trigger" href="#modal_action">Deny</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- End: Request Table -->

		<!-- Pagination -->
		<div class="col s12 m10 right">
			<ul class="pagination right">
				<li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
				<li class="active"><a href="#!">1</a></li>
				<li class="waves-effect"><a href="#!">2</a></li>
				<li class="waves-effect"><a href="#!">3</a></li>
				<li class="waves-effect"><a href="#!">4</a></li>
				<li class="waves-effect"><a href="#!">5</a></li>
				<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
			</ul>
		</div>
		<!-- End: Pagination -->

		<!-- Modal Structure -->>
        <div id="modal_action" class="modal">
          <div class="modal-content">
          	<form>
          		 <div id="remarks" class="row">
			        <div class="col s12 m8">
			          <h5>Remarks:</h5>
			          <div class="row">
			            <div class="input-field col s12 m10">
			              <textarea id="remarks" class="materialize-textarea"></textarea>
			              <label for="remarks">Input remarks.</label>
			            </div>
			          </div>
			        </div>
			      </div>
          	</form>
          </div>
          <div style="clear:both;">
          </div>
          <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Back</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
          </div>
        </div>
	      <!-- End: Modal Structure -->
		<!-- End: Requests Table Container-->
	</div>
</div>
@stop

