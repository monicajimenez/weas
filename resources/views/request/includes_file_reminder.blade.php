<div class="col l10" id="forfeiture_reminder_container">
    <h5>Forfeiture Reminder:</h5>
	<div class="row">
		<div class="input-field col l6">
		    <input name="first_reminder" type="date" class="datepicker validate" 
		    	@if(isset($details->re_first)) value="{{$details->re_first}}" @endif>
		    <label for="first_reminder">First Reminder</label>
	    </div>
	    <div class="input-field col l6">
		    <input name="second_reminder" type="date" class="datepicker validate"
		    	@if(isset($details->re_second)) value="{{$details->re_second}}" @endif>
		    <label for="second_reminder">Second Reminder</label>
	    </div>
	</div>
	<div class="row">
	  <div class="input-field col l6">
	    <input name="notice_of_forfeiture" type="date" class="datepicker validate"
		    	@if(isset($details->re_notice)) value="{{$details->re_notice}}" @endif>
	    <label for="notice_of_forfeiture">Notice of Forfeiture</label>
	  </div>
	</div>
	<div class="row">
	  <div class="input-field col l6">
	    <input name="number_of_amortization_paid" type="text" class="validate"
		    	@if(isset($details->re_amort)) value="{{$details->re_amort}}" @endif>
	    <label for="number_of_amortization_paid">Number of Amortization Paid</label>
	  </div>
	</div>
</div>

<div class="row">
	<div class="col l10">
	  <div class="divider">
	  </div>
	</div>
</div>