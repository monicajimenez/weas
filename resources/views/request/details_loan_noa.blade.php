<div class="row">
  <div class="col s10 m5">
    <h5>Loan Details:</h5>
    <div class="row">
      <div class="input-field col s12">
        <input disabled name="bank_name" type="text" class="validate" value="@if(isset($details->bank->bank_name)){{ trim($details->bank->bank_name)}}@endif" >
        <label for="bank_name">Bank Name</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input disabled name="approved_amount" type="text" class="validate" value="{{trim($details->rfc_amount)}}">
        <label for="approved_amount">Approved Amount</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input disabled name="turnover_date" type="text" class="validate" value=""><!-- {{ date('M d, Y', strtotime(trim($details->rfc_turnover))) }} -->
        <label for="turnover_date">Turnover Date</label>
      </div>
    </div>
  </div>
  <div class="col s10 m5 padding-left-25 hide-on-small-only">
    <h5>NOA Details:</h5>
    <div class="row">
      <div class="input-field col s12">
        <input disabled name="noa_number" type="text" class="validate" value="{{ $details->rfc_noa }}">
        <label for="noa_number">NOA Number</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input disabled name="contractor" type="text" class="validate" value="{{ $details->con_code }}">
        <label for="contractor">Contractor</label>
      </div>
    </div>
  </div>
  <div class="col s10 m5 hide-on-med-and-up">
    <h5>NOA Details:</h5>
    <div class="row">
      <div class="input-field col s12">
        <input disabled name="noa_number" type="text" class="validate" value="{{ $details->rfc_noa }}">
        <label for="noa_number">NOA Number</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input disabled name="contractor" type="text" class="validate" value="{{ $details->con_code }}">
        <label for="contractor">Contractor</label>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col s12">
    <div class="divider">
    </div>
  </div>
</div>