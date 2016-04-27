@extends("layouts/master")
@section('sitetitle', 'Dashboard')
@section('pagetitle', 'Dashboard')
@section("content")
<div class="row">
	<div class="col s12 m12 l12">
		<!-- Requests Statistics -->
		<div class="row">
			<div class="col s12 m10 l10 right">
				<div id="card-stats">
				    <div class="row">
						<!-- View Errors -->
					    @if($errors->any())
					    	@foreach($errors->all() as $error)
					          <p class="errors">{{$error}}</p>
					        @endforeach
					    @endif
				    	<!-- End: View Errors -->
				    	<!--- Statistics-->
				    	<div class="col s12 m6 l3">
				        	<div class="card">
				                <div class="card-content blue white-text">
				                    <p class="card-stats-title">
				                    	<i class="material-icons left">thumbs_up_down</i>
				                    	Pending Requests
				                    </p>
				                    <h4 class="card-stats-number center-align">{{trim($statistics['Pending'])}}</h4>
				                </div>
				                <div class="card-action blue darken-2">
				                    <div id="clients-bar"><canvas width="290" height="25" style="display: inline-block; width: 290px; height: 25px; vertical-align: top;"></canvas></div>
				                </div>
				            </div>
			        	</div>

			        	<div class="col s12 m6 l3">
				        	<div class="card">
				                <div class="card-content yellow darken-1 white-text">
				                    <p class="card-stats-title">
				                    	<i class="material-icons left">pause_circle_outline</i>
				                    	On-Hold Requests
				                    </p>
				                    <h4 class="card-stats-number center-align">{{trim($statistics['On-Hold'])}}</h4>
				                </div>
				                <div class="card-action yellow darken-2">
				                    <div id="clients-bar"><canvas width="290" height="25" style="display: inline-block; width: 290px; height: 25px; vertical-align: top;"></canvas></div>
				                </div>
				            </div>
			        	</div>

				    	<div class="col s12 m6 l3">
				        	<div class="card">
				                <div class="card-content green white-text">
				                    <p class="card-stats-title">
				                    	<i class="material-icons left">thumbs_up_down</i>
				                    	Signed Requests
				                    </p>
				                    <h4 class="card-stats-number center-align">{{trim($statistics['Signed'])}}</h4>
				                </div>
				                <div class="card-action green darken-2">
				                    <div id="clients-bar"><canvas width="290" height="25" style="display: inline-block; width: 290px; height: 25px; vertical-align: top;"></canvas></div>
				                </div>
				            </div>
			        	</div>

				    	<div class="col s12 m6 l3">
				        	<div class="card">
				                <div class="card-content red white-text">
				                    <p class="card-stats-title">
				                    	<i class="material-icons left">thumb_down</i>
				                    	Denied Requests
				                    </p>
				                    <h4 class="card-stats-number center-align">{{trim($statistics['Denied'])}}</h4>
				                </div>
				                <div class="card-action red darken-2">
				                    <div id="clients-bar"><canvas width="290" height="25" style="display: inline-block; width: 290px; height: 25px; vertical-align: top;"></canvas></div>
				                </div>
				            </div>
			        	</div>
				        	<!--- End: Statistics-->
				    </div>
				</div>
			</div>
		</div>
		<!-- End: Requests Statistics -->

		<!-- Requests Table Container -->
		<!-- Request Table Label -->
		<div class="row">
			<div class="col s11 m10 right">
				<h5 class="left-align">Unsigned Requests
					@if($statistics_unsigned > 0)
						<em class="red-text">({{$statistics_unsigned}})</em>
					@endif
				</h5>
			</div>
		</div>
		<!-- End: Request Table Label -->

    	<!-- Search Field -->
	    @if($statistics_unsigned > 0)
	    <div class="row">
	      <div class="col s12 m3 right">	
	        <form action="<?php route('dashboard') ?>" method="get">
	          <div class="input-field">
	            <input type="search" id="search-field" class="field" required maxlength="" name="search">
	            <label for="search-field"><i class="mdi-action-search"></i></label>
	            <i class="mdi-navigation-close close"></i>
	          </div>
	        </form>
	      </div>
	    </div>
	    @endif
	    <!-- End: Search Field -->

		<!-- TABS -->
		<div class="row">
		    <div class="col s12 m10 right">
		      <ul class="tabs">
		        <li class="tab col s3"><a class="active" href="#unsignedPendingRequestTab">Unsigned Pending Requests</a></li>
		        <li class="tab col s3"><a href="#unsignedOnHoldRequestTab">Unsigned On-Hold Requests</a></li>
		      </ul>
		    </div>
		    <!-- Unsigned Pending Request Tab -->
		    <div id="unsignedPendingRequestTab" class="row">

		    	<!-- Request Table -->
				 @if ($pending_requests->count()>0)
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
					              @foreach ($pending_requests as $pending_request)
					                <tr>
					                  <td>{{ trim($pending_request->rfc_code) }}</td>
					                  <td>{{ trim($pending_request->rfc_name) }}</td>
					                  <td>{{ trim($pending_request->project_no) }}</td>
					                  <td>{{ trim($pending_request->lot_no) }}</td>
					                  <td>{{ trim($pending_request->rfc_scheme) }}</td>
					                  <td>
					                  	@if($pending_request->rfc_alertdate)
					                      {{ date('m/d/Y', strtotime(trim($pending_request->rfc_alertdate))) }}
					                    @endif
					                  </td>
					                  <td>
					                  	@if($pending_request->rfc_DOR)
					                      {{ date('m/d/Y', strtotime(trim($pending_request->rfc_DOR))) }}
					                    @endif
					                  </td>
					                  <td>
					                    <a href="{{ route('request.show', trim($pending_request->rfc_code) ) }}">View</a>
					                    <!-- <a class="modal-trigger" href="#modal_remarks">Approve</a> -->
					                  <!-- <a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a> --></td>
					                </tr>
					              @endforeach
					            </tbody>
							</table>
						</div>
					</div>
				@else
		          	<div class="row">
			          	<div class="col s12 m10 right">
							<div class="center-align">All taken cared of.</div>
						</div>
					</div>
		        @endif
				<!-- End: Request Table -->

				<!-- Pagination -->
				<div class="col s12 m10 right">
					<ul class="pagination right">
						<?php echo $pending_requests->setPageName('pending_request_page'); ?>
					</ul>
				</div>
				<!-- End: Pagination -->
		    </div>
		    <!-- End: Unsigned Pending Request Tab -->
		    <!-- Unsigned On-Hold Request Tab -->
		   	<div id="unsignedOnHoldRequestTab" class="row">
		    	<!-- Request Table -->
				 @if ($onhold_requests->count()>0)
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
					              @foreach ($onhold_requests as $onhold_request)
					                <tr>
					                  <td>{{ trim($onhold_request->rfc_code) }}</td>
					                  <td>{{ trim($onhold_request->rfc_name) }}</td>
					                  <td>{{ trim($onhold_request->project_no) }}</td>
					                  <td>{{ trim($onhold_request->lot_no) }}</td>
					                  <td>{{ trim($onhold_request->rfc_scheme) }}</td>
					                  <td>
					                  	@if($onhold_request->rfc_alertdate)
					                      {{ date('m/d/Y', strtotime(trim($onhold_request->rfc_alertdate))) }}
					                    @endif
					                  </td>
					                  <td>
					                  	@if($onhold_request->rfc_DOR)
					                      {{ date('m/d/Y', strtotime(trim($onhold_request->rfc_DOR))) }}
					                    @endif
					                  </td>
					                  <td>
					                    <a href="{{ route('request.show', trim($onhold_request->rfc_code) ) }}">View</a>
					                    <!-- <a class="modal-trigger" href="#modal_remarks">Approve</a> -->
					                  <!-- <a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a> --></td>
					                </tr>
					              @endforeach
					            </tbody>
							</table>
						</div>
					</div>
				@else
		          	<div class="row">
			          	<div class="col s12 m10 right">
							<div class="center-align">All taken cared of.</div>
						</div>
					</div>
		        @endif
				<!-- End: Request Table -->

				<!-- Pagination -->
				<div class="col s12 m10 right">
					<ul class="pagination right">
						<?php echo $onhold_requests->setPageName('onhold_request_page'); ?>
					</ul>
				</div>
				<!-- End: Pagination -->
		    </div>
		    <!-- End: Unsigned On-Hold Request Tab -->
		 </div>
		<!-- End: TABS -->
		<!-- End: Requests Table Container-->

		<!-- Requests Filed Request Container -->
		<!-- Filed Request Table Label -->
		<div class="row">
			<div class="col s11 m10 right">
				<h5 class="left-align">Filed Requests
					@if(count($filed_requests) > 0)
						<em class="red-text">({{count($filed_requests)}})</em>
					@endif
				</h5>
			</div>
		</div>
		<!-- End: Filed Request Table Label -->

		<div id="filed_request">
			<!-- Request Table -->
			 @if ($filed_requests->count()>0)
				<div class="row">
					<div class="col s12 m10 right">
						<table class="responsive-table hoverable">
							<thead class="">
								<tr>
									<th data-field="code" class="center-align">
										 Code
									</th>
									<th data-field="project_name" class="center-align">
										 Project Name
									</th>
									<th data-field="lot_code" class="center-align">
										 Lot Code
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
				              @foreach ($filed_requests as $filed_request)
				                <tr>
				                  <td>{{ trim($filed_request->rfc_code) }}</td>
				                  <td>{{ trim($filed_request->project_no) }}</td>
				                  <td>{{ trim($filed_request->lot_no) }}</td>
				                  <td>{{ trim($filed_request->rfc_scheme) }}</td>
				                  <td>
				                  	@if($filed_request->rfc_alertdate)
				                      {{ date('m/d/Y', strtotime(trim($filed_request->rfc_alertdate))) }}
				                    @endif
				                  </td>
				                  <td>
				                  	@if($filed_request->rfc_DOR)
				                      {{ date('m/d/Y', strtotime(trim($filed_request->rfc_DOR))) }}
				                    @endif
				                  </td>
				                  <td>
				                  <?php 
				                  	$rfc_code = explode('-', trim($filed_request->rfc_code));
				                  ?>
				                    <a href="{{ route('request.show', trim($filed_request->rfc_code) ) }}">View</a>
				                    <a href="{{ route('request.edit', ['request_id' => trim($filed_request->rfc_code), 'filing_type' => $rfc_code['0']]) }}">Edit</a>
				                </tr>
				              @endforeach
				            </tbody>
						</table>
					</div>
				</div>
			@else
	          	<div class="row">
		          	<div class="col s12 m10 right">
						<div class="center-align">All taken cared of.</div>
					</div>
				</div>
	        @endif
			<!-- End: Request Table -->
		</div>
		<!-- End Filed Request Table Container -->
	</div>
</div>
@stop

