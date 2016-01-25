<div class="col l10">
  <h5>Document/s with buyer, to be cancelled, subject to request approval</h5>
  <div class="row">
    <div class="input-field col l3">
        <input @if(isset($details->user_approver->rfcline_A) && $details->user_approver->rfcline_A == 'y')checked @endif class="with-gap" name="attachment_type[a]" type="checkbox" id="purchase_order" />
        <label for="purchase_order">Purchase Order</label>
    </div>
    <div class="input-field col l3">
      <input @if(isset($details->user_approver->rfcline_B) && $details->user_approver->rfcline_B == 'y')checked @endif class="with-gap" name="attachment_type[b]" type="checkbox" id="reservation_agreement" />
      <label for="reservation_agreement">Reservation Agreement</label>
    </div>
    <div class="input-field col l3">
      <input @if(isset($details->user_approver->rfcline_C) &&  $details->user_approver->rfcline_C == 'y')checked @endif lass="with-gap" name="attachment_type[c]" type="checkbox" id="contract_to_sell" />
      <label for="contract_to_sell">Contract to Sell</label>
    </div>
    <div class="input-field col l3">
      <input @if(isset($details->user_approver->rfcline_D) &&  $details->user_approver->rfcline_D == 'y')checked @endif class="with-gap" name="attachment_type[d]" type="checkbox" id="investment_estimated_sheet" />
      <label for="investment_estimated_sheet">Investment Estimated Sheet</label>
    </div>
  </div>
  <div class="row">
    <div class="input-field col l3">
      <input @if(isset($details->user_approver->rfcline_Others) &&  count($details->user_approver->rfcline_Others)) checked @endif class="with-gap" name="attachment_type[others]" type="checkbox"  id="others"/>
      <label for="others">Others</label>
    </div>

    <div class="input-field col l3" id="other_attachment_container">
      <input name="other_attachment" @if(isset($details->user_approver->rfcline_Others)) value="{{$details->user_approver->rfcline_Others}}" @endif type="text"/>
      <label for="other_attachment">Others</label>
    </div>
  </div>
</div>

<div class="row">
  <div class="col l10">
    <div class="divider">
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#others').change(function(){ 
      $('#other_attachment_container').toggle();
    }); 
  });
</script>