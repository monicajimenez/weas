<div class="row">
	<div class="input-field col s12">
	  <input disabled name="request_type" type="text" class="validate" value="{{ $details->req_desc }}">
	  <label for="owners_name">Request Type</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s12">
	  <input disabled name="from" type="text" class="validate" value="{{ $details->rfc_from }}">
	  <label for="owners_name">From</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s12">
	  <input disabled name="to" type="text" class="validate" value="{{ $details->rfc_to }}">
	  <label for="to">To</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s12">
	  <input disabled name="prepared_by" type="text" class="validate" value="{{ $details->rfc_name }}">
	  <label for="prepared_by">Prepared By</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s12">
		<textarea disabled name="notes" class="materialize-textarea">{{ $details->rfc_note }}</textarea>
	     <label for="notes">Notes</label>
	</div>
</div>
