@extends("layouts/master")
@section('sitetitle', 'File '.$request_type.' Request: ')
@section('pagetitle', 'File '.$request_type.' Request: ')
@section("content")
<div class="row">
  <div class="col l10 right">
    <form action="" method="get">     

      <!-- View Errors -->
      <!-- @if($errors->any())
        @foreach($errors->all() as $error)
          <p class="errors">{{$error}}</p>
        @endforeach
      @endif -->
      <!-- End: View Errors -->

      <!-- Basic Details ---->
      <div class="col l10">

        <h5>Basic Details:</h5>

        @if($request_type =='RFR')
          <div class="row">
            <div class="input-field col l3">
                <input class="with-gap" name="nature_reopening[]" value ="Code-001" type="radio" id="forfeiture" checked/>
                <label for="forfeiture">Forfeiture</label>
            </div>
            <div class="input-field col l3">
              <input class="with-gap" name="nature_reopening[]" value="Code-002" type="radio" id="request_for_change" />
              <label for="request_for_change">Request for Change</label>
            </div>
          </div>
        @endif

        <div class="row">
          <div class="input-field col l6">
            <input disabled name="date_file" type="text" class="validate" value="{{date('M d, Y')}}">
            <label for="date_file">Date Filled</label>
          </div>
          <div class="input-field col l6">
            <input disabled name="request_code" type="text" class="validate" value="">
            <label for="request_code">Request Code</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col l6" id="project_type_container">
            <select id="project_type">
              <option value="" disabled selected>Choose your option</option>
              @foreach($projects as $project)
                <option value="{{$project->project_no}}">{{$project->project_no}} - {{$project->project_desc}}</option>
              @endforeach
            </select>
            <label>Project Name</label>
          </div>
          @if($request_type == 'RFR')
            <div class="input-field col l6" id="rfc_ref_no_container">
              <select id="rfc_ref_no">
                <option value="" disabled selected>Choose your option</option>
                @foreach($rfc_refs as $rfc_ref)
                  <option value="{{$rfc_ref->rfc_code}}">{{$rfc_ref->rfc_code}} - {{$rfc_ref->project_no}} - {{$rfc_ref->rfc_name}}</option>
                @endforeach
              </select>
              <label>Reference Number (RFC)</label>
            </div>
          @endif
          <div class="input-field col l6">
            <input name="lot_code" type="text" class="validate" value="">
            <label for="lot_code">Lot Code</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="date_reserved" type="date" class="datepicker validate" value="">
            <label for="date_reserved">Date Reserved</label>
          </div> 
          <div class="input-field col l6">
            <input name="model_type" type="text" class="validate" value="">
            <label for="model_type">Model Type</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="lot_area" type="text" class="validate" value="">
            <label for="lot_area">Lot Area (sqm)</label>
          </div>
          <div class="input-field col l6">
            <input name="floor_area" type="text" class="validate" value="">
            <label for="floor_area">Floor Area</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="owners_name" type="text" class="validate" value="">
            <label for="owners_name">Owner's Name</label>
          </div>
          @if($request_type == 'RFR')
            <div class="input-field col l6">
              <input name="reasons" type="text" class="validate" value="">
              <label for="reasons">Reasons</label>
            </div>
          @endif
          @if($request_type =='RFC' || $request_type =='QAC')
            <div class="input-field col l6">
              <input name="payment_scheme" type="text" class="validate" value="">
              <label for="payment_scheme">Payment Scheme</label>
            </div>
          @endif
        </div>
        <div class="row">
          @if($request_type =='QAC')
            <div class="input-field col l6">
              <input name="contract_amount" type="text" class="validate" value="">
              <label for="contract_amount">Contract Amount</label>
            </div>
          @endif
        </div>
      </div>
      <!-- End: Basic Details ---->

      <div class="row">
        <div class="col l10">
          <div class="divider">
          </div>
        </div>
      </div>

      <!-- Additional Includes for RFC Type of Requests -->
      @if($request_type =='RFC')
        @include("request.file_request_type")
      @endif
      <!-- End: Additional Includes for RFC Type of Requests -->

      <!-- Table of Approvers -->
      <div class="row">
        <div class="col l10">
          <h5>Approvers:</h5>
          <table class="responsive-table" id="approvers_table">
          <thead class="">
          <tr>
            <th data-field="app_code" class="index center-align">
               Level
            </th>
            <th data-field="app_name" class="center-align">
               Closing
            </th>
            <th data-field="closing_id" class="center-align">
               Name
            </th>
            <th data-field="description" class="center-align">
               Position
            </th>
            <th data-field="app_level" class="center-align">
               Status
            </th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          </table>
        </div>
      </div>
      <!-- End: Table of Approvers -->

      <div class="row">
        <div class="col l10">
          <div class="divider">
          </div>
        </div>
      </div>

      <!-- Document Checklist -->
      @if($request_type =='RFC')
        @include("request.file_documents_check_list")
      @endif
      <!-- End: Document Checklist -->

      <!-- Document Checklist -->
      @if($request_type =='RFR')
        @include("request.file_reminder")
      @endif
      <!-- End: Document Checklist -->

      <!-- Remarks -->
      @if($request_type !='RFC')
        @include("request.remarks")
      @endif
      <!-- End: Remarks --> 

      <!-- Buttons-->
      <div class="fixed-action-btn" style="bottom: 80px;">
        <a class="btn-floating btn-large">
        <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
          <li><button type="submit" name="approver_response" value="Denied" class="btn-floating btn-small waves-effect waves-light green"><i class="material-icons">done</i></button></li>
          <li><button type="reset" name="approver_response" value="Signed" class="btn-floating btn-small waves-effect waves-light red"><i class="material-icons">not_interested</i></button></li>
        </ul>
      </div>
      <!-- End: Buttons-->
       <input type="hidden"  id="_token" value="{{{ csrf_token() }}}" />
       <input type="hidden"  id="filing_type" value="{{{ $request_type }}}" />
    </form>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    $('#rfc_ref_no_container').hide();

    $('#project_type').change(function(){            
      $.ajax({
        url: '{{route("getrequesttypeapprovers")}}',
        type: 'POST',
        data: {'project_type' :$('#project_type').val(), 'filing_type': $('#filing_type').val(), '_token': $('#_token').val() },
        success: function(data){
            var newRowContent;

            $.each( data, function( key, approver ) {
              console.log(key + ": " + approver + "\n"); 
              newRowContent = "<tr><td class='index'>" + approver["app_level"] + "</td>" +
                              "<td>" + approver["close_desc"] + "</td>" +
                              "<td>" + approver["app_fname"] + " " + approver["app_lname"] + "</td>" +
                              "<td>" + "[TO QUERY]" + "</td>" +
                              "<td>" + approver["mandatory"] + "</td>";
              $("#approvers_table tbody").append(newRowContent);
            });

            $("#approvers_table tbody").append("</tr>");
        }
      });      
    }); 
  
    var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
        return $helper;
    },
    
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
    };

    $("#approvers_table tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex
    }).disableSelection();

    $('#request_for_change').click(function(){  
        $('#project_type_container').toggle(); 
        $('#rfc_ref_no_container').toggle();
        $('#forfeiture_reminder_container').toggle();
    }); 

    $('#forfeiture').click(function(){  
        $('#project_type_container').toggle(); 
        $('#rfc_ref_no_container').toggle();
        $('#forfeiture_reminder_container').toggle();
    }); 

  });
</script>
@stop