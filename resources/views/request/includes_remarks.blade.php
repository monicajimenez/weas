<div id="remarks" class="row">
	<div class="col s10 m10">
	  <h5>Remarks:</h5>
	  <div class="row">
	    <div class="input-field col s12 m12">
	    	<textarea id="remarks" name="remarks">
	    		@if(isset($details['user_approver']['rfcline_remarks'])){{$details['user_approver']['rfcline_remarks']}}
	    		@elseif( count(Request::old('remarks')) ) {{Request::old('remarks')}}
	    		@endif
	    	</textarea>
	      <label for="remarks">Input remarks.</label>
	    </div>
	  </div>
	</div>
</div>