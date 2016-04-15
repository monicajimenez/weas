@extends("layouts/master")
@section('sitetitle', 'Edit '.$filing_type.' Request: ')
@section('pagetitle', 'Edit '.$filing_type.' Request: ')
@section("content")
<div class="row">
  <div class="col l10 right">
    <form action="{{ route('request.update')}}" method="post">    
    <!-- Required hidden fields -->
    <input type="hidden" name="_token" value="{{ csrf_token()}}"/>
    <input type="hidden"  name="filing_type" value="{{ $filing_type }}" />
    <input name="request_code" type="hidden" value="{{ $details->rfc_code }}">

    <!-- Per request type required hidden fields -->
    @if(isset($rfr_type))
      <input type="hidden" id="nature_of_reopening" name="nature_of_reopening" value="{{$rfr_type}}" />
    @endif

    @if($filing_type =='RFC' || $filing_type =='QAC')
    @endif
      <!-- View Errors -->
      @if($errors->any())
        @foreach($errors->all() as $error)
          <p class="errors">{{$error}}</p>
        @endforeach
      @endif
      <!-- End: View Errors -->

      <!-- Basic Details ----> 
      <div class="col l10">

        <h5>Basic Details:</h5>

        @if($filing_type =='RFR')
          <div class="row">
            <div class="input-field col l6">
              @if($rfr_type=='forfeiture') 
                <input disabled class="" id="forfeiture" name="forfeiture" value="Forfeiture" type="text" />
              @else
                <input disabled class="" id="request_for_change" name="request_for_change" value="Request for Change" type="text" />
              @endif
                <label for="rfr_nature">RFR Nature</label>
            </div>
          </div>
        @endif

        <div class="row">
          <div class="input-field col l6">
            <input disabled name="date_filed" type="text" class="validate" value="{{$details->rfc_DOR}}">
            <label for="date_filed">Date Filed</label>
          </div>
          <div class="input-field col l6">
            <input disabled name="request_type_code" type="text" class="validate" value="{{$details->rfc_code}}">
            <label for="request_type_code">Request Code</label>
          </div>
        </div>

        <div class="row">
          @if($filing_type == 'RFR')
            @if($details->re_nature == 'Forfeiture')
              <div class="input-field col l3" id="project_type_container_forfeiture">
                <select id="project_type" name="project_type">
                  @foreach($projects as $project)
                    <option value="{{$project->project_no}}" @if($details->project_no == $project->project_no)selected @endif>{{$project->project_no}} - {{$project->project_desc}}</option>
                  @endforeach
                </select>
                <label for="project_type">Project Name</label>
              </div>
            @else
              <div class="input-field col l3">
                <input @if(isset($uneditable_fields) && isset($uneditable_fields['project_type']))disabled @endif name="project_type" name="project_type" type="text" class="validate" value="{{$details->project_no}}">
                @if(isset($uneditable_fields) && isset($uneditable_fields['project_type']))
                  <input name="project_type" name="project_type" type="hidden" class="validate" value="{{$details->project_no}}">
                @endif
                <label for="project_type">Project Name</label>
              </div>
            @endif
            <div class="input-field col l3" id="rfc_ref_no_container">              
              @if($details->re_nature == 'Forfeiture')
                  <input @if(isset($uneditable_fields) && isset($uneditable_fields['rfc_ref_no']))disabled @endif name="rfc_ref_no" type="text" class="validate" value="{{$details->rfc_refno}}">
              @else
                <a class="waves-effect waves-light btn modal-trigger" id="btn_modal_rfc_request_reference" href="#modal_rfc_request_reference">
                  <i class="small material-icons">add</i>
                </a>
                <input @if(isset($uneditable_fields) && isset($uneditable_fields['rfc_ref_no']))disabled @endif name="rfc_ref_no" type="text" class="validate" value="{{$default_req_reference}}">
              @endif
              <label>Reference Number (RFC)</label>
            </div>
          @else
            <div class="input-field col l6" id="project_type_container_forfeiture">
              <select id="project_type" name="project_type">
                @foreach($projects as $project)
                  <option @if($details->project_no == $project->project_no)selected @endif value="{{$project->project_no}}">{{$project->project_no}} - {{$project->project_desc}}</option>
                @endforeach
              </select>
              <label>Project Name</label>
            </div>
          @endif
          <div class="input-field col l6">
           <input @if(isset($uneditable_fields) && isset($uneditable_fields['lot_code']))disabled @endif name="lot_code" type="text" class="validate" value="{{$details->lot_no}}">
            @if(isset($uneditable_fields) && isset($uneditable_fields['lot_code']))
              <input type="hidden" name="lot_code" class="validate" value="{{$details->lot_no}}">
            @endif
            <label for="lot_code">Lot Code</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="date_reserved" type="date" class="datepicker validate" value="{{$details->sales_date}}">
            <label for="date_reserved">Date Reserved</label>
          </div> 
          <div class="input-field col l6">
            <input name="model_type" type="text" class="validate" value="{{$details->rfc_model}}">
            <label for="model_type">Model Type</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="lot_area" type="text" class="validate" value="{{$details->rfc_landarea}}">
            <label for="lot_area">Lot Area (sqm)</label>
          </div>
          <div class="input-field col l6">
            <input name="floor_area" type="text" class="validate" value="{{$details->rfc_floorarea}}">
            <label for="floor_area">Floor Area</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="owners_name" type="text" class="validate" value="{{$details->rfc_name}}">
            <label for="owners_name">Owner's Name</label>
          </div>
          @if($filing_type == 'RFR')
            <div class="input-field col l6">
              <input name="reasons" type="text" class="validate" value="{{$details->re_reasons}}">
              <label for="reasons">Reasons</label>
            </div>
          @endif
          @if($filing_type =='RFC' || $filing_type =='QAC')
            <div class="input-field col l6">
              <input name="payment_scheme" type="text" class="validate" value="{{$details->rfc_scheme}}">
              <label for="payment_scheme">Payment Scheme</label>
            </div>
          @endif
        </div>
        <div class="row">
          @if($filing_type =='QAC')
            <div class="input-field col l6">
              <input name="contract_amount" type="text" class="validate" value="{{$details->rfc_contamt}}">
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

      <!-- Additional Details for RFC Type of Requests -->
      @if($filing_type =='RFC')
        @include("request.edit_request_type")
      @endif
      <!-- End: Additional Includes for RFC Type of Requests -->

      <!-- Table of Approvers -->
      <div class="row">
        <div class="col l10">
          <h5>Approvers:</h5>
          <table class="responsive-table" id="table_approvers">
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
                <td>{{ $approver->close_desc}}
                    <input type="hidden" name="close_codes[]" value="{{$approver->close_code}}">
                </td>
                <td>{{ $approver->app_fname}} {{ $approver->app_lname}}
                    <input type="hidden" name="approvers[]" value="{{$approver->app_code}}">
                </td>
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
        <div class="col l10">
          <div class="divider">
          </div>
        </div>
      </div>

      <!-- Document Checklist -->
      @if($filing_type =='RFC')
        @include("request.includes_file_documents_check_list")
      @endif
      <!-- End: Document Checklist -->

      <!-- Forfeiture Reminder -->
      @if($filing_type =='RFR' && $rfr_type == 'forfeiture')
        @include("request.includes_file_reminder")
      @endif
      <!-- End: Forfeiture Reminder -->

      <!-- Remarks -->
      <!-- In RFC, no remarks field is needed because the notes fields acts both as notes and remarks -->
      @if($filing_type !='RFC')
        @include("request.includes_remarks")
      @endif
      <!-- End: Remarks --> 

      <!-- Buttons-->
      <div class="fixed-action-btn click-to-toggle" style="bottom: 80px;">
        <a class="btn-floating btn-large red">
          <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
          <li><a><button type="button" class="btn-floating btn-small waves-effect waves-light modal-trigger" title="Attachment" href="#modal_attachments"><i class="material-icons">attach_file</i></button></a></li>
          <li><a><button type="submit" name="approver_response" value="Edit" title="Update" class="btn-floating btn-small waves-effect waves-light green"><i class="material-icons">done</i></button></a></li>
        </ul>
      </div>
      <!-- End: Buttons-->
    </form>

     <!-- Modal Includes -->
      @include("request.modal_attachment")
      @include("request.modal_add_approver")

      @if($filing_type =='RFR')
        @include("request.modal_rfc_request_reference")
      @endif
      <!-- End: Modal Includes -->

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){        
    $('label').addClass('active');

    //Function getting new token
    function getToken()
    {
      $.ajax({
          type: 'GET',
          url: '{{route("token")}}',
          async: false,
          context: this,
          data: "",
          timeout: this.url_check_timeout,
          success: function (token) {
              $('meta[name="csrf-token"]').attr('content', token );
          }.bind(this),
          error: function () {
              this.lastError = NetError.invalidURL;
          }.bind(this)
      });
    }

    //Function for populating the Approvers' table
    function populateApproversTable(data)
    {
      var newRowContent;
      $('#table_approvers tbody').empty();

      $.each( data, function( key, approver ) {
        console.log(approver);
        newRowContent = "<tr>" +
                        "<td class='index center-align'>" + approver["app_level"] + "</td>" +
                        "<td class='center-align'>" + approver["close_desc"] +
                                "<input type='hidden' name='close_codes[]' value='"+ approver["close_code"] +"'>" +  "</td>" +
                        "<td class='center-align'>" + approver["app_fname"] + " " + approver["app_lname"] + 
                                "<input type='hidden' name='approvers[]' value='"+ approver["app_code"] +"'>" + "</td>" +
                        "<td class='center-align'>" + approver["app_position"] + "</td>" +
                        "<td class='center-align'>" + approver["mandatory"] + "</td>";

        if(approver["mandatory"] != 'Y')
        {
          newRowContent += "<td class='center-align'>" + "<a name='"+ approver["app_code"]+"' class='delete_app btn-flat'><i class='tiny material-icons'>delete</i></a>" + "</td>";
        }
        else
        {
          newRowContent += "<td class='delete'>" + "" + "</td>";
        }

        $("#table_approvers tbody").append(newRowContent);
      });
    }

    //QAC and RFR (Forfeiture)  Filing: Handler for Project Name Dropdown and populating the Approvers' table thereafter
    //RFC Filing: Handler for Project Name Dropdown and populating the RFC REF dropdown thereafter
    $('#project_type').change(function(){
      getToken();
      filing_type = $('input[name="filing_type"]').val();
      
      if( filing_type == 'RFR' || filing_type == 'QAC')
      {
        request_type_code = '';

        if(filing_type == 'RFR')
        {
          request_type_code = 'Req-027'; //request_type_code for Forfeitures
        }
        if(filing_type == 'QAC')
        {
          request_type_code = 'Req-021'; //request_type_code for QAC
        }

        $.ajax({
          url: '{{route("getrequesttypeapprovers")}}',
          type: 'POST',
          data: {'project_code' :$('#project_type').val(), 'filing_type': $('input[name="filing_type"]').val(), 
                 'request_type_code': request_type_code, '_token': $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            console.log('to enter populate Approvers Table');
              populateApproversTable(data);
          }
        });
      }                 
    });

    //RFR (Request for Change) Filing: Handler for RFC Request Reference Dropdown and Populating of RFCs Table thereafter
    $('#rfc_request_reference').change(function(){
      getToken();
      var data = $('#rfc_request_reference').val().split('.');
      var request_code = data[0];
      var project_no = data[1];
      var request_description = data[2];
        $.ajax({
          url: '{{route("getRFCRequestReferences")}}',
          type: 'POST',
          data: {'request_code' : request_code, 'project_no': project_no, '_token': $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            console.log(data);
              $('#table_rfc_request_reference tbody').empty();

              $.each( data, function( key, rfc_ref ) {
                newRowContent = "<tr>" +
                                "<td class='index center-align'>" + rfc_ref["rfc_code"] + "</td>" +
                                "<td class='center-align'>" + rfc_ref["rfc_name"] +  "</td>" +
                                "<td class='center-align'>" + rfc_ref["lot_no"] + "</td>" +
                                "<td class='center-align'>" + 
                                  "<a id='" + rfc_ref["rfc_code"] + "." + request_code + "." + project_no + "." + request_description + "." + rfc_ref["lot_no"] +"' class='add_rfc_request_referece btn-flat'><i class='tiny material-icons'>add</i></a>" +
                                "</td>"+
                                "</tr>";
                $("#table_rfc_request_reference tbody").append(newRowContent);
              });
          }
        })
    });
  
    //RFR Filing: Handler for adding of the RFC Code in the form upon user click in the RFC Refs Table and Populating the Approvers' Table
    $('#table_rfc_request_reference').on('click', '.add_rfc_request_referece', function() {
      getToken();
      data = $(this).attr('id').split('.');
      request_type_code = data[0];
      project_code = data[2];
      request_type_code = data[1];
      request_description = data[3];
      lot_code = data[4];
      filing_type = 'RFR';

      $.ajax({
        url: '{{route("getrequesttypeapprovers")}}',
        type: 'POST',
        data: {'project_code' : project_code, 'filing_type': filing_type, 'request_type_code': request_type_code ,
               '_token': $('meta[name="csrf-token"]').attr('content') },
        success: function(data){
             populateApproversTable(data);
        }
      });
      
      $('[name=project_type]').val(project_code);
      $('[name=rfc_ref_no]').val(request_type_code + ' : ' + request_description);
      $('[name=lot_code]').val(lot_code);
      $('#btn_modal_rfc_request_reference').hide();
    });

    /*RFC Filing: Handler of the Request Type Drop Down under Additional Details
    Requires that a Project Name be chosen in the Basic Details Area*/
    $('#req_ref').change(function(){
      getToken();
      var data = $('#req_ref').val().split('+');
      $.ajax({
        url: '{{route("getrequesttypeapprovers")}}',
        type: 'POST',
        data: {'project_code' :$('#project_type').val(), 'filing_type': $('input[name="filing_type"]').val(),
               'req_ref': data[0], '_token': $('meta[name="csrf-token"]').attr('content') },
        success: function(data){
            populateApproversTable(data);
        }
      });              
    });

    //APPROVER TABLE SORTING FUNCTIONALITIES
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

    $("#table_approvers tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex
    }).disableSelection();
    

    // DYNAMICALLY ADDED COMPONENTS' EVENT LISTENERS
    $('#table_approvers').on('click', '.delete_app', function() {
       $(this).parents('tr').remove();
       $('td.index', 'table').each(function (i) {
            $(this).html(i + 1);
        });
    });

    //Required Fields for the different RFR filing types
    function requiredForfeitureFields()
    {
      //Remove required class from RFR->RFC fields
      $('[name=first_reminder]').removeClass('required');
      $('[name=second_reminder]').removeClass('required');
      $('[name=notice_of_forfeiture]').removeClass('required');
      $('[name=number_of_amortization_paid]').removeClass('required');

      //Add required class from RFR->Forfeiture fields
      $('[name=project_type]').addClass('required');
    }

    function requiredRFRRFCFields()
    {
      //Remove required class from RFR->Forfeiture fields
      $('[name=project_type]').removeClass('required');

      //Add required class from RFR->RFC fields
      $('[name=first_reminder]').addClass('required');
      $('[name=second_reminder]').addClass('required');
      $('[name=notice_of_forfeiture]').addClass('required');
      $('[name=number_of_amortization_paid]').addClass('required');
    }

    //TOGGLE FUNCTIONALITIES
    function toogleEvents()
    {
        $('#table_approvers tbody').empty();
        document.getElementById("form_file").reset();
        $('#project_type_container_forfeiture').toggle(); 
        $('#rfc_ref_no_container').toggle();
        $('#forfeiture_reminder_container').toggle();
    }

    //RFR Onclick Events
    $('#request_for_change').click(function(){  
      requiredRFRRFCFields();
      toogleEvents();
      document.getElementById('request_for_change').checked = true;
    }); 

    $('#forfeiture').click(function(){  
      requiredForfeitureFields();
      toogleEvents();
    }); 

  });
</script>
@stop