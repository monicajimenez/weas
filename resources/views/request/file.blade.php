@extends("layouts/master")
@section('sitetitle', 'File '.$filing_type.' Request: ')
@section('pagetitle', 'File '.$filing_type.' Request: ')
@section("content")
<div class="row">
  <div class="col l10 right">
    <form class="form-horizontal" id="form_file" method="post" action="{{ route('request.store') }}">
    <input type="hidden" name="_token" value="{{ csrf_token()}}"/>
    <input type="hidden"  name="filing_type" value="{{ $filing_type }}" />

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
            <input type="hidden" name="name_flag_nature_reopening" value="{{Request::old('name_flag_nature_reopening')}}">
            <div class="input-field col l3">
                <input class="with-gap" id="forfeiture" name="nature_reopening[]" value="Code-001" type="radio" 
                      @if(  Request::old('name_flag_nature_reopening') || 
                            !Request::old('name_flag_nature_reopening') == 'Code-001' )
                              checked 
                      @endif />
                <label for="forfeiture">Forfeiture</label>
            </div>
            <div class="input-field col l3">
              <input class="with-gap" id="request_for_change" name="nature_reopening[]" value="Code-002" type="radio"
                      @if(  Request::old('name_flag_nature_reopening') == 'Code-002' )
                              checked 
                      @endif />
              <label for="request_for_change">Request for Change</label>
            </div>
          </div>
        @endif

        <div class="row">
          <div class="input-field col l6">
            <input name="date_filed" type="text" class="validate" value="{{date('M d, Y')}}" disabled>
            <input name="date_filed" type="hidden" class="validate" value="{{date('M d, Y')}}">
            <label for="date_filed">Date Filed</label>
          </div>
          <div class="input-field col l6">
            <input name="request_type_code" type="text" class="validate" value="" disabled>
            <label for="request_type_code">Request Code</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col l6" id="project_type_container_forfeiture">
            <select id="project_type" name="project_type" value="{{Request::old('project_type')}}">
              <option @if(!Request::old('project_type')) selected @endif>Choose your option</option>
              @foreach($projects as $project)
                <option value="{{$project->project_no}}" 
                    @if(Request::old('project_type') == $project->project_no) selected @endif >
                        {{$project->project_no}} - {{$project->project_desc}}
                </option>
              @endforeach
            </select>
            <label for="project_type">Project Name</label>
          </div>
          <div class="input-field col l3" id="project_type_container_rfr_rfc">
            <input id="project_type" name="project_type" type="text" class="validate" value="{{Request::old('project_type')}}" @if($filing_type=='RFC') disabled @endif>
            <label for="project_type">Project Name</label>
          </div>
          @if($filing_type == 'RFR')
            <div class="input-field col l3" id="rfc_ref_no_container">
              <a class="waves-effect waves-light btn modal-trigger" id="btn_modal_rfc_request_reference" href="#modal_rfc_request_reference">
                <i class="small material-icons">add</i>
              </a>
              <input name="rfc_ref_no" type="text" class="validate" value="{{Request::old('rfc_ref_no')}}">
              <label for="rfc_ref_no">Reference Number (RFC)</label>
            </div>
          @endif
          <div class="input-field col l6">
            <input name="lot_code" type="text" class="validate" value="{{Request::old('lot_code')}}">
            <label for="lot_code">Lot Code</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="date_reserved" type="date" class="datepicker validate" value="{{Request::old('date_reserved')}}">
            <label for="date_reserved">Date Reserved</label>
          </div> 
          <div class="input-field col l6">
            <input name="model_type" type="text" class="validate" value="{{Request::old('model_type')}}">
            <label for="model_type">Model Type</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="lot_area" type="text" class="validate" value="{{Request::old('lot_area')}}">
            <label for="lot_area">Lot Area (sqm)</label>
          </div>
          <div class="input-field col l6">
            <input name="floor_area" type="text" class="validate" value="{{Request::old('floor_area')}}">
            <label for="floor_area">Floor Area</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col l6">
            <input name="owners_name" type="text" class="validate" value="{{Request::old('owners_name')}}">
            <label for="owners_name">Owner's Name</label>
          </div>
          @if($filing_type == 'RFR')
            <div class="input-field col l6">
              <input name="reasons" type="text" class="validate" value="{{Request::old('reasons')}}">
              <label for="reasons">Reasons</label>
            </div>
          @endif
          @if($filing_type =='RFC' || $filing_type =='QAC')
            <div class="input-field col l6">
              <input name="payment_scheme" type="text" class="validate" value="{{Request::old('payment_scheme')}}">
              <label for="payment_scheme">Payment Scheme</label>
            </div>
          @endif
        </div>
        <div class="row">
          @if($filing_type =='QAC')
            <div class="input-field col l6">
              <input name="contract_amount" type="text" class="validate" value="{{Request::old('contract_amount')}}">
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
        @include("request.file_request_type")
      @endif
      <!-- End: Additional Details for RFC Type of Requests -->

      <!-- Table of Approvers -->
      <div class="row">
        <div class="col l10">
          <h5>Approvers:</h5>
          <table class="responsive-table" id="table_approvers">
          <thead class="">
          <tr>
            <th data-field="app_level" class="index center-align">
               Level
            </th>
            <th data-field="app_closing" class="center-align">
               Closing
            </th>
            <th data-field="app_name" class="center-align">
               Name
            </th>
            <th data-field="app_pos" class="center-align">
               Position
            </th>
            <th data-field="app_mandatory" class="center-align">
               Mandatory
            </th>
            <th data-field="app_delete" class="center-align">
               Delete
            </th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          </table>
          <!-- <div class="section right" id="container_modal_add_approver"><a class="waves-effect waves-light btn modal-trigger" href="#modal_add_approver"><i class="small material-icons">add</i></a></div> -->
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

      <!-- RFR Forfeiture Reminder -->
      @if($filing_type =='RFR')
        @include("request.includes_file_reminder")
      @endif
      <!-- End: RFR Forfeiture Reminder -->

      <!-- Remarks -->
      @if($filing_type !='RFC')
        @include("request.includes_remarks")
      @endif
      <!-- End: Remarks --> 

      <!-- Buttons-->
      <div class="fixed-action-btn click-to-toggle" style="bottom: 80px;">
        <a class="btn-floating btn-large">
        <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
          <li><button type="submit" value="Save" title="Save" class="btn-floating btn-small waves-effect waves-light green"><i class="material-icons">done</i></button></li>
          <li><button type="reset" value="Cancel" title="Cancel" class="btn-floating btn-small waves-effect waves-light red"><i class="material-icons">not_interested</i></button></li>
        </ul>
      </div>
      <!-- End: Buttons-->
    </form>

     <!-- Modal Includes -->
      @if($filing_type =='RFR')
        @include("request.modal_rfc_request_reference")
      @endif
      <!-- End: Modal Includes -->

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    //Initialize global variables
    var_filing_type = $('input[name="filing_type"]').val();

    //Initializes the newly opened form or for repopulating fields
    onLoad();

    function onLoad()
    {    
        //Initialization
        var_project_type = $('#project_type').val();
        var_rfc_req_ref = $('input[name="input_hidden_req_ref"]').val();
        var_name_flag_nature_reopening = $('input[name="name_flag_nature_reopening"]').val();
        var_rfc_ref_no =  $('[name=rfc_ref_no]').text();

        //Hide fields that are not included, depending on the filing type
        $('#rfc_ref_no_container').hide();
        $('#container_modal_add_approver').hide();
        $('#project_type_container_rfr_rfc').hide();
        $('#project_type_container_rfr_rfc #project_type').prop('disabled','true');

        //For repopulating approvers table and the fields that triggers it.
        if( ( var_project_type && var_project_type != 'Choose your option' &&
              ( 
                  (var_filing_type == 'RFC' && var_rfc_req_ref && var_rfc_req_ref != 'Choose your option') || 
                  (var_filing_type == 'QAC') ||
                  (var_filing_type == 'RFR')
              )
            ) ||
            var_name_flag_nature_reopening == 'Code-002' 
          )
        {
          //QAC: Call the project type dropdown handler to query values to populate Approvers Table
          //RFC: Call the project type dropdown handler to query values for Request Type Dropdown
          projectTypeChangeHandler();


          //Additional Step for RFR->Request for Change
          if( var_filing_type == 'RFR' && var_name_flag_nature_reopening == 'Code-002')
          {   
            requiredRFRRFCFields();
            rfrRFCAdditionalSetUp();

            //If rfc ref number needs to be repopulated
            if(var_rfc_ref_no)
            {
                var_lot_code = $('[name=lot_code]').text();
                var_project_type = $('[name=project_type]').text();
                var_rfc_ref_num_split = var_rfc_ref_no.split(':');
                var_request_type_code = var_rfc_ref_num_split[0];
                var_request_description = var_rfc_ref_num_split[1]; 

                rfrRfcReqRefTableValuesHandler( var_project_type, var_request_type_code, 
                                                var_request_description, var_lot_code);
            }
          }

          //Additional Step for RFCs
          if(var_filing_type == 'RFC')
          {      
            //Display the chosen request type.
            var_rfc_req_ref_split = var_rfc_req_ref.split('+');

            $('#container_req_ref input').val(var_rfc_req_ref_split[1]);
            $('#container_req_ref #req_ref').find('#'+ $.trim(var_rfc_req_ref_split[0])).prop("selected","selected");
            $('input[name="input_hidden_req_ref"]').val(var_rfc_req_ref);
            
            //Call the rfc request type handler to query the approvers
            rfcReqRefHandler(var_rfc_req_ref);
          }
        }
    }

    //Function getting new token.
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
        newRowContent = "<tr>" +
                        "<td class='index center-align'>" + approver["app_level"] + "</td>" +
                        "<td class='center-align'>" + approver["close_desc"] +
                                "<input type='hidden' name='close_codes[]' value='"+ approver["close_code"] +"'>" +  "</td>" +
                        "<td class='center-align'>" + approver["app_fname"] + " " + approver["app_lname"] + 
                                "<input type='hidden' name='approvers[]' value='"+ approver["app_code"] +"'>" + "</td>" +
                        "<td class='center-align'>" + approver["app_position"] + "</td>" +
                        "<td class='center-align'>" + approver["mandatory"] + "</td>";

        if(approver["mandatory"] != 'Y' && approver["app_level"] != 1)
        {
          newRowContent += "<td class='center-align'>" + "<a name='"+ approver["app_code"]+"' class='delete_app btn-flat'><i class='tiny material-icons'>delete</i></a>" + "</td>";
        }
        else
        {
          newRowContent += "<td class='delete'>" + "" + "</td>";
        }

        $("#table_approvers tbody").append(newRowContent);
      });
    
      /*$('#container_modal_add_approver').show();*/
    }

    //Handler for Add Approver Button below Approvers' Table
    /*$('#container_modal_add_approver').click(function(){
      $.ajax({
        url: '{{route("user.approver")}}',
        method: 'POST',
        data: {'_token': $('meta[name="csrf-token"]').attr('content')},
        success: function(data){
          var newRowContent;

          $.each( data, function( key, approver ) {
            newRowContent = "<tr>" +
                            "<td class='index center-align' id='app_code'>" + approver["app_code"] + "</td>" +
                            "<td class='center-align' id='app_name'>" + approver["app_fname"] + " " + approver["app_lname"] + "</td>" +
                            "<td class='center-align' id='app_position'>" + approver["app_position"] + "</td>" +
                            "<td class='center-align'>" + "<a name='"+ approver["app_code"]+"' class='add_app btn-flat'><i class='tiny material-icons'>add</i></a>" + "</td>";

            $("#table_add_approvers tbody").append(newRowContent);
          });
        }
      });  
    });*/
    
    //RFC, QAC and RFR (Forfeiture)  Filing: Handler for Project Name Dropdown and populating the Approvers' table thereafter
    //RFC Filing: Handler for Project Name Dropdown and populating the RFC REF dropdown thereafter
    $('#project_type').change(function(){
      projectTypeChangeHandler();
    });

    function projectTypeChangeHandler()
    {
      getToken();
      
      if( var_filing_type == 'RFR' || var_filing_type == 'QAC')
      {
        request_type_code = '';

        if(var_filing_type == 'RFR')
        {
          request_type_code = 'Req-027'; //request_type_code for Forfeitures
        }
        if(var_filing_type == 'QAC')
        {
          request_type_code = 'Req-021'; //request_type_code for QAC
        }

        $.ajax({
          url: '{{route("getrequesttypeapprovers")}}',
          method: 'POST',
          data: {'project_code' :$('#project_type').val(), 'filing_type': var_filing_type,
                 'request_type_code': request_type_code, '_token': $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
              populateApproversTable(data);
          }
        });
      }
      else if( var_filing_type == 'RFC')
      {
          $.ajax({
            url: '{{route("getrequesttype")}}',
            method: 'POST',
            data: {'request_type': var_filing_type, 'project_type' :$('#project_type').val(), 
                  '_token': $('meta[name="csrf-token"]').attr('content') },
            success: function(data){
              pointerReqRef = $('#req_ref');
              liPointer = $('#req_ref').prev();
              req_ref_val = $('#req_ref').val();

              pointerReqRef.empty();
              liPointer.empty();

              liPointer.append('<li class="disabled"><span>Choose your option</span></li>');
              pointerReqRef.append('<option value="disabled">Choose your option</option>');
            
              $.each( data, function( key, rfc_ref ) {
                liPointer.append($("<li></li>").html($("<span></span>").attr("value",rfc_ref['req_desc'])
                                                                       .attr("class", $.trim(rfc_ref['req_code']))
                                                                       .text(rfc_ref['req_desc'])));
                pointerReqRef.append($("<option></option>").attr("value", rfc_ref['req_code'] + "+" + rfc_ref['req_desc'])
                                                           .attr("id", $.trim(rfc_ref['req_code']))
                                                           .text(rfc_ref['req_desc']));
              });
            }
          });           
      }
    }

    //RFC Filing: Handler of the Request Type Drop Down onlick under Additional Details
    //Requires that a Project Name be chosen in the Basic Details Area
    $('#container_req_ref ul').on('click', 'li', function(){
      $('#container_req_ref input').val($(this).text());
      pointerSpan = $(this).find("span");
      $('#container_req_ref #req_ref').find('#'+ pointerSpan.attr('class')).prop("selected","selected");
      $('input[name="input_hidden_req_ref"]').val($('#req_ref').val());
      rfcReqRefHandler($('#req_ref').val());
    });

    //RFC Filing: Handler of the Request Type Drop Down under Additional Details
    //Requires that a Project Name be chosen in the Basic Details Area
    function rfcReqRefHandler(var_rfc_req_ref)
    {
      getToken();
      data = var_rfc_req_ref.split('+');

      $.ajax({
        url: '{{route("getrequesttypeapprovers")}}',
        method: 'POST',
        data: {'project_code' :$('#project_type').val(), 'filing_type': var_filing_type,
               'req_ref': data[0], '_token': $('meta[name="csrf-token"]').attr('content') },
        success: function(data){
            populateApproversTable(data);
        }
      });
    }

    //RFR (Request for Change) Filing: Handler for RFC Request Reference Dropdown and Populating of RFCs Table thereafter
    $('#rfc_request_reference').change(function(){
      getToken();
      var data = $('#rfc_request_reference').val().split('.');
      var request_code = data[0];
      var project_no = data[1];
      var request_description = data[2];
        $.ajax({
          url: '{{route("getRFCRequestReferences")}}',
          method: 'POST',
          data: {'request_code' : request_code, 'project_no': project_no, '_token': $('meta[name="csrf-token"]').attr('content') },beforeSend: function() {
              $('.preloader-wrapper').css('visibility', 'visible');
           },
          success: function(data){
              $('#table_rfc_request_reference tbody').empty();

              $.each( data, function( key, rfc_ref ) {
                newRowContent = "<tr>" +
                                "<td class='index center-align'>" + rfc_ref["rfc_code"] + "</td>" +
                                "<td class='center-align'>" + rfc_ref["rfc_name"] +  "</td>" +
                                "<td class='center-align'>" + rfc_ref["lot_no"] + "</td>" +
                                "<td class='center-align'>" + 
                                  "<a id='" + rfc_ref["rfc_code"] + "." + request_code + "." + project_no + "." + request_description + "." + 
                                  rfc_ref["lot_no"] +"' class='add_rfc_request_referece btn-flat'><i class='tiny material-icons'>add</i></a>" +
                                "</td>"+
                                "</tr>";
                $("#table_rfc_request_reference tbody").append(newRowContent);
              });
              
              $('.preloader-wrapper').css('visibility', 'hidden');
          }
        })
    });
  
    //RFR Filing: Handler for adding of the RFC Code in the form upon user click in the RFC Refs Table and Populating the Approvers' Table
    $('#table_rfc_request_reference').on('click', '.add_rfc_request_referece', function() {
      getToken();
      data = $(this).attr('id').split('.');
      project_code = data[2];
      request_type_code = data[1];
      request_description = data[3];
      lot_code = data[4];

      rfrRfcReqRefTableValuesHandler(project_code, request_type_code, request_description, lot_code)
    });

    function rfrRfcReqRefTableValuesHandler(project_code, request_type_code, request_description, lot_code)
    {
      $.ajax({
        url: '{{route("getrequesttypeapprovers")}}',
        method: 'POST',
        data: {'project_code' : project_code, 'filing_type': var_filing_type, 'request_type_code': request_type_code ,'_token': $('meta[name="csrf-token"]').attr('content') },
        success: function(data){
             populateApproversTable(data);
        }
      });
      
      $('[name=project_type]').val(project_code);
      $('[name=project_type]').text(project_code);
      $('[name=rfc_ref_no]').val(request_type_code + ' : ' + request_description);
      $('[name=rfc_ref_no]').text(request_type_code + ' : ' + request_description);
      $('[name=lot_code]').val(lot_code);
      $('[name=lot_code]').text(lot_code);
      $('#project_type_container_rfr_rfc input[name=project_type]').prop('disabled', false);
      $('input[name=lot_code]').prop('disabled', false);
      $('#rfc_ref_no_container label').addClass('active');
      $('label[for=lot_code]').addClass('active');
      $('#project_type_container_rfr_rfc label[for=project_type]').addClass('active');
      $('#btn_modal_rfc_request_reference').hide();
    }

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

    /*$('#table_add_approvers').on('click', '.add_app', function() {
       newRowContent = "<tr><td class='index center-align'>" + " " + "</td>" +
                      "<td class='center-align'>" + "" + "</td>" +
                      "<td class='center-align'>" + $(this).parents('tr').children('#app_name').html() + "</td>" +
                      "<td class='center-align'>" + $(this).parents('tr').children('#app_position').html() + "</td>" +
                      "<td class='center-align'>" + "N" + "</td>" +
                      "<td class='center-align'>" + "<a name='"+ $(this).parents('tr').children('#app_code').html() +"' class='delete_app btn-flat'><i class='tiny material-icons'>delete</i></a>" + "</td>";

      $("#table_approvers tbody").append(newRowContent);
    });*/

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

    function rfrRFCAdditionalSetUp()
    {
      $('#project_type_container_rfr_rfc input[name=project_type]').prop('disabled', true);
      $('input[name=lot_code]').prop('disabled', true);
      $('input[name=name_flag_nature_reopening]').val('Code-002');
      toogleEvents();
      document.getElementById('request_for_change').checked = true;
    }

    //TOGGLE FUNCTIONALITIES
    function toogleEvents()
    {
        $('#table_approvers tbody').empty();
        document.getElementById("form_file").reset();
        $('#project_type_container_forfeiture').toggle(); 
        $('#project_type_container_rfr_rfc').toggle(); 
        $('#rfc_ref_no_container').toggle();
        $('#forfeiture_reminder_container').toggle();
    }

    //RFR Onclick Events
    $('#request_for_change').click(function(){  
      requiredRFRRFCFields();
      rfrRFCAdditionalSetUp();
    }); 

    $('#forfeiture').click(function(){  
      requiredForfeitureFields();
      $('input[name=name_flag_nature_reopening]').val('Code-001');
      toogleEvents();
    }); 

  });
</script>
@stop