<div class="admin_fee">
  <div id="modal_admin_fee" class="modal">
    <div class="modal-content">
	    <h5>Admin Fees:</h5>
	    @if(!is_null($details->admin_fees) && count($details->admin_fees) <= 0)
	        No fees.
	    @else
		    <table class="responsive-table hoverable">
		        <thead class="">
		          <tr>
		            <th data-field="name" class="center-align">
		               Name
		            </th>
		            <th data-field="remarks" class="center-align">
		               Remarks
		            </th>
		            <th data-field="with_admin_fee" class="center-align">
		               With Admin Fee
		            </th>
		            <th data-field="amount" class="center-align">
		               Amount
		            </th>
		            <th data-field="date" class="center-align">
		               Date
		            </th>
		            <th data-field="code" class="center-align">
		               Code
		            </th>
		          </tr>
		        </thead>
		        <tbody>
		          @foreach ($details->admin_fees as $admin_fee)
		            <tr>
		              <td>{{ trim($admin_fee->admin_code) }}</td>
		              <td>{{ trim($admin_fee->admin_remarks) }}</td>
		              <td>{{ trim($admin_fee->admin_flag) }}</td>
		              <td>{{ trim($admin_fee->admin_fee) }}</td>
		              <td>{{ trim($admin_fee->admin_date) }}</td>
		              <td>{{ trim($admin_fee->admin_code) }}</td>
		            </tr>
		          @endforeach
		        </tbody>
		      </table>
	    @endif
    </div>
    <div style="clear:both;">
    </div> 
    <div class="col s12 m12">
	    <form action="{{route('adminfee.store')}}" files="true" enctype="multipart/form-data" method="post">
	      <div class="modal-footer">
	        <h5>Add admin fee?</h5>
	        <p>
	        	<input name="admin_flag" type="radio" id="admin_flag_yes" value="Y" checked/>
	      		<label for="admin_flag_yes">Yes</label>
	          	<input name="admin_flag" type="radio" selected id="admin_flag_no" value="N" />
	      		<label for="admin_flag_no">No</label>
	        </p>
	        <p>
	        	<input name="amount" type="text" class="validate" value="">
	             <label for="amount">Amount</label>

	        	<input name="remarks" type="text" class="validate" value="">
	             <label for="remarks">Remarks</label>
	        </p>

	        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Back</a>
	        <button type="submit" id="add_admin_fee" class=" modal-action modal-close waves-effect waves-green btn-flat">Add Admin Fee</button>
	        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"></input>
	        <input type="hidden" name="request_id" value="{{trim($details->rfc_code)}}"></input>
	      </div>
	    </form>
	</div>
  </div>
</div>