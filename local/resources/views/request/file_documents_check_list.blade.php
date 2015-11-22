<div class="col l10">
  <h5>Document/s with buyer, to be cancelled, subject to request approval</h5>
  <div class="row">
    <div class="input-field col l3">
        <input class="with-gap" name="attachment_type[]" value ="Code-001" type="checkbox" id="purchase_order" />
        <label for="purchase_order">Purchase Order</label>
    </div>
    <div class="input-field col l3">
      <input class="with-gap" name="attachment_type[]" value="Code-002" type="checkbox" id="reservation_agreement" />
      <label for="reservation_agreement">Reservation Agreement</label>
    </div>
    <div class="input-field col l3">
      <input class="with-gap" name="attachment_type[]" value="Code-002" type="checkbox" id="contract_to_sell" />
      <label for="contract_to_sell">Contract to Sell</label>
    </div>
    <div class="input-field col l3">
      <input class="with-gap" name="attachment_type[]" value="Code-002" type="checkbox" id="investment_estimated_sheet" />
      <label for="investment_estimated_sheet">Investment Estimated Sheet</label>
    </div>
  </div>
  <div class="row">
    <div class="input-field col l3">
      <input class="with-gap" name="attachment_type[]" value="Code-003" type="checkbox"  id="others"/>
      <label for="others">Others</label>
    </div>
    <div class="input-field col l3" id="other_attachment_container" style="display:none;">
      <input name="other_attachment" value="" type="text"/>
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