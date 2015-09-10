@extends("layouts/master")
@section('sitetitle', 'Request Details')
@section('pagetitle', 'Request Details')
@section("content")
<div class="row">
  <div class="col s11 m10 right">
    <form action="{{ route('request.update', ['request_id' => trim($details->rfc_code)]) }}" method="get">
      <!-- Basic and Project Details -->
      <div class="row">
        <div class="col s10 m5">
          <h5>Basic Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="qac_code" type="text" class="validate" value="{{ $details->rfc_code }}">
              <label for="qac_code">Request Code</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="date_filed" type="text" class="validate" value="{{ date('M d, Y', strtotime($details->rfc_DOR)) }}">
              <label for="date_filed">Date Filed</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="date_qualified" type="text" class="validate" value="{{ date('M d, Y', strtotime($details->rfc_alertdate)) }}">
              <label for="date_qualified">Date Qualified</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="owners_name" type="text" class="validate" value="{{ $details->rfc_name }}">
              <label for="owners_name">Owner's Name</label>
            </div>
          </div>
        </div>
        <div class="col s10 m5 padding-left-25 hide-on-small-only">
          <h5>Project Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="project" type="text" class="validate" value="{{ $details->project_no }}">
              <label for="project">Project</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="cotract_amount" type="text" class="validate" value="@if(trim($details->rfc_contamt)){{number_format(trim($details->rfc_contamt)) }}@endif">
              <label for="cotract_amount">Contract Amount</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="lot_code" type="text" class="validate" value="{{ $details->lot_no }}">
              <label for="lot_code">Lot Code</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="lot_area" type="text" class="validate" value="{{ $details->rfc_landarea}}">
              <label for="lot_area">Lot Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="floor_area" type="text" class="validate" value="{{ $details->rfc_floorarea }}">
              <label for="floor_area">Floor Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="house_model" type="text" class="validate" value="{{ $details->rfc_model }}">
              <label for="house_model">House Model</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="payment_scheme" type="text" class="validate" value="{{ $details->rfc_scheme }}">
              <label for="payment_scheme">Payment Scheme</label>
            </div>
          </div>
        </div>
        <div class="col s10 m5 hide-on-med-and-up">
          <h5>Project Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="project" type="text" class="validate" value="{{ $details->project_no }}">
              <label for="project">Project</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="cotract_amount" type="text" class="validate" value="@if(trim($details->rfc_contamt)){{number_format(trim($details->rfc_contamt)) }}@endif">
              <label for="cotract_amount">Contract Amount</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="lot_code" type="text" class="validate" value="{{ $details->lot_no }}">
              <label for="lot_code">Lot Code</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="lot_area" type="text" class="validate" value="{{ $details->rfc_landarea}}">
              <label for="lot_area">Lot Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="floor_area" type="text" class="validate" value="{{ $details->rfc_floorarea }}">
              <label for="floor_area">Floor Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="house_model" type="text" class="validate" value="{{ $details->rfc_model }}">
              <label for="house_model">House Model</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input disabled name="payment_scheme" type="text" class="validate" value="{{ $details->rfc_scheme }}">
              <label for="payment_scheme">Payment Scheme</label>
            </div>
          </div>
        </div>
      </div>
      <!-- End: Basic and Project Details -->
      <div class="row">
        <div class="col s12">
          <div class="divider">
          </div>
        </div>
      </div>
      <!-- Loan and NOA Details -->
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
              <input disabled name="turnover_date" type="text" class="validate" value="{{ date('M d, Y', strtotime(trim($details->rfc_turnover))) }}">
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
      <!-- End: Loan and NOA Details -->
      <div class="row">
        <div class="col s12">
          <div class="divider">
          </div>
        </div>
      </div>
      <!-- Table of Approvers -->
      <div class="row">
        <div class="col s10">
          <h5>Approvers:</h5>
          <table class="responsive-table">
          <thead class="">
          <tr>
            <th data-field="level" class="center-align">
               Level
            </th>
            <th data-field="closing" class="center-align">
               Closing
            </th>
            <th data-field="name" class="center-align">
               Name
            </th>
            <th data-field="position" class="center-align">
               Position
            </th>
            <th data-field="status" class="center-align">
               Status
            </th>
            <th data-field="remarks" class="center-align">
               Remarks
            </th>
          </tr>
          </thead>
          <tbody>
            @foreach( $details->approvers as $approver)
              <tr>
                <td>{{ $approver->rfcline_level}}</td>
                <td>{{ $approver->close_code}}</td>
                <td>{{ $approver->app_fname}} {{ $approver->app_lname}}</td>
                <td>{{ $approver->app_position}}</td>
                <td>{{ $approver->rfcline_stat}}</td>
                <td>{{ $approver->rfcline_remarks}}</td>
              </tr>
            @endforeach
          </tbody>
          </table>
        </div>
      </div>
      <!-- End: Table of Approvers -->
      <div class="row">
        <div class="col s12">
          <div class="divider">
          </div>
        </div>
      </div>
      <!-- Remarks -->
      @if(isset($signed) && isset($authorize_to_sign) && $signed == '0' && $authorize_to_sign == 1)
        @if(trim($details->rfc_stat) == 'Pending' || trim($details->rfc_stat) == 'On-hold')
          @include("request.remarks")
        @endif
      @endif
      <!-- End: Remarks -->    
      <!-- Buttons-->
      <div class="fixed-action-btn" style="bottom: 80px;">
        <a class="btn-floating btn-large">
        <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
          <li><a class="btn-floating btn-small waves-effect waves-light modal-trigger" href="#modal_attachments"><i class="material-icons">description</i></a></li>
          @if(isset($signed) && isset($authorize_to_sign) && $signed == '0' && $authorize_to_sign == 1)
            @if( trim($details->rfc_stat) == 'Pending' || trim($details->rfc_stat) == 'On-Hold')
            <li><button type="submit" name="approver_response" value="Denied" class="btn-floating btn-small waves-effect waves-light red"><i class="material-icons">thumb_down</i></button></li>
            <li><button type="submit" name="approver_response" value="Signed" class="btn-floating btn-small waves-effect waves-light green"><i class="material-icons">thumb_up</i></button></li>
            @endif
            @if(trim($details->rfc_stat) == "Pending")
            <li><button type="submit" name="approver_response" value="On-Hold" class="btn-floating btn-small waves-effect waves-light yellow"><i class="material-icons">pause_circle_outline</i></button></li>
            @endif
          @endif
        </ul>
      </div>
      <!-- End: Buttons-->
      </form>
      
      <!-- Attachments -->
      @include("request.attachment")
      <!-- End: Attachments -->
  </div>
</div>
@stop