<div class="col l10">
    <h5>Additonal Details:</h5>
	<div class="row">
		<div class="input-field col l6" id="container_req_ref">
		    <select id="req_ref" name="req_ref">
		       	<option value="" disabled selected>Choose your option</option>
		    	@foreach($req_refs as $req_ref)
		      		<option value="{{$req_ref->req_code}} + {{$req_ref->req_desc}}">{{$req_ref->req_desc}}</option>
		      	@endforeach
		    </select>
	    	<label>Request Type</label>
	    </div>
	    <div class="input-field col l6">
		    <input name="req_note" type="text" class="validate" value="">
		    <label for="req_note">Note</label>
	    </div>
	</div>
	<div class="row">
	  <div class="input-field col l6">
	    <input name="from" type="text" class="validate" value="">
	    <label for="from">From</label>
	  </div>
	  <div class="input-field col l6">
	    <input name="to" type="text" class="validate" value="">
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