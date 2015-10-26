@if($status == 'completed')
	This request has been completely approved by all approvers.
@elseif($status == 'Signed')
	This request awaits your approval.
@elseif($status == 'On-Hold')
	This request has been on-hold.
@elseif($status == 'Denied')
	This request has been denied.
@elseif($status == 'Reset')
	This request has been reset by the Administrator.
@elseif($status == 'Filed')
	Your request has been received by our system and sent to the first approver.
@endif
Please check your Electronic Approval System (EAS).

<!-- Basic and Project Details -->
<div class="row">
	<!-- Basic Details ---->
	<div class="col s10 m5">
	  <h4><u>Basic Details:</u></h4>

	  <div class="row"><b>Request Code:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_code }}</div>
	  <div class="row"><b>Date Filed:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($rfc_DOR){{ date('M d, Y', strtotime($rfc_DOR)) }}@endif</div>
	  <div class="row"><b>Date Qualified:</b>&nbsp;&nbsp;&nbsp;&nbsp; @if($rfc_alertdate){{date('M d, Y', strtotime($rfc_alertdate))}}@endif</div>
	  <div class="row"><b>Owner's Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_name }}</div>

	  <!-- Additional Includes for RFC Type of Requests -->
	  @if( str_contains(trim($rfc_code),'RFC') || str_contains(trim($rfc_code),'RFR'))
	  	<div class="row"><b>Request Type:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $req_desc }}</div>
		<div class="row"><b>From:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_from }}</div>
		<div class="row"><b>To:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_to }}</div>
		<div class="row"><b>Prepared By:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_name }}</div>
		<div class="row"><b>Notes:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_note }}</div>
	  @endif
	  <!-- End: Additional Includes for RFC Type of Requests -->
	</div>
	<!-- End: Basic Details ---->

	<!-- Project Details ---->
	<div class="col s10 m5">
	  <h4><u>Project Details:</u></h4>

	  <div class="row"><b>Project:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $project_no }}</div>
	  <div class="row"><b>Contract Amount:</b>&nbsp;&nbsp;&nbsp; @if(trim($rfc_contamt)){{number_format(trim($rfc_contamt)) }}@endif</div>
	  <div class="row"><b>Lot Code:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $lot_no }}</div>
	  <div class="row"><b>Lot Area:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_landarea}}</div>
	  <div class="row"><b>Floor Area:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_floorarea }}</div>
	  <div class="row"><b>House Model:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rfc_model }}</div>
	  <div class="row"><b>Payment Scheme:</b>&nbsp;&nbsp;&nbsp;{{ $rfc_scheme }}</div>
	</div>
	<!-- End: Project Details ---->

</div>
<!-- End: Basic and Project Details -->
