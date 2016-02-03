<div class="col l10">
    <h5>Additonal Details:</h5>
	<div class="row">
		<div class="input-field col l6">
		    <select id="req_ref" name="req_ref">
		    	@foreach($req_refs as $req_ref)
		      		<option value="{{$req_ref->req_code}} + {{$req_ref->req_desc}}" @if($details->req_code == $req_ref->req_code)selected @endif >{{$req_ref->req_desc}}</option>
		      	@endforeach
		    </select>
	    	<label>Request Type</label>
	    </div>
	    <div class="input-field col l6">
		    <input name="notes" type="text" class="validate" value="{{$details->rfc_note}}">
		    <label for="notes">Note</label>
	    </div>
	</div>
	<div class="row">
	  <div class="input-field col l6">
	    <input name="from" type="text" class="validate" value="{{$details->rfc_from}}">
	    <label for="from">From</label>
	  </div>
	  <div class="input-field col l6">
	    <input name="to" type="text" class="validate" value="{{$details->rfc_to}}">
	    <label for="to">To</label>
	  </div>
	</div>
</div>

<div class="row">
	<div class="col l10">
	  <div class="divider">
	  </div>
	</div>
</div>