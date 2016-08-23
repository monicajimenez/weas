<div class="col l10">
    <h5>Additonal Details:</h5>
	<div class="row">
		<div class="input-field col l6" id="container_req_ref">
			<input name="input_hidden_req_ref" type="hidden" class="validate" value="{{Request::old('req_ref')}}">
		    <select id="req_ref" name="req_ref" class="form-control">
		       	<option value="Choose your option" @if(Request::old('req_ref')) selected @endif>Choose your option</option>
		    </select>
	    	<label>Request Type</label>
	    </div>
	    <div class="input-field col l6">
		    <input name="req_note" type="text" class="validate" value="{{Request::old('req_note')}}">
		    <label for="req_note">Note</label>
	    </div>
	</div>
	<div class="row">
	  <div class="input-field col l6">
	    <input name="from" type="text" class="validate" value="{{Request::old('from')}}">
	    <label for="from">From</label>
	  </div>
	  <div class="input-field col l6">
	    <input name="to" type="text" class="validate" value="{{Request::old('to')}}">
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