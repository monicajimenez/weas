@extends("layouts/master")
@section('sitetitle', 'File PR Request: ')
@section('pagetitle', 'File PR Request: ')
@section("content")
<div class="row">
  <div class="col l10 right">
    <form class="form-horizontal" id="form_file" method="post" action="{{ route('request.store') }}">
    <input type="hidden" name="_token" value="{{ csrf_token()}}"/>
    <input type="hidden"  name="filing_type" value="pr" />

      <!-- View Errors -->
      @if($errors->any())
        @foreach($errors->all() as $error)
          <p class="errors">{{$error}}</p>
        @endforeach
      @endif
      <!-- End: View Errors -->

      <!-- Basic Details --> 
      <div class="col l10 section">
        <div class="row">
          <div class="input-field col l2">
              <input class="with-gap" id="supplies" name="pr_type[]" value="Req-040" type="radio" checked/>
              <label for="supplies">Supplies</label>
          </div>
          <div class="input-field col l2">
            <input class="with-gap" id="capex" name="pr_type[]" value="Req-041" type="radio"/>
            <label for="capex">CAPEX</label>
          </div>
          <div class="input-field col l2">
            <input class="with-gap" id="capex_it" name="pr_type[]" value="Req-042" type="radio"/>
            <label for="capex_it">CAPEX IT</label>
          </div>
          <div class="input-field col l3 right">
            <input name="date_filed" type="text" class="validate" value="{{date('M d, Y')}}" disabled>
            <input name="date_filed" type="hidden" class="validate" value="{{date('M d, Y')}}">
            <label for="date_filed">Date Filed</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col l3 right">
            <input name="requesting_department" type="text" class="validate" value="{{$requesting_department->dept_name}}" disabled>
            <label for="requesting_department">Requesting Department</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col l3 right">
            <select id="deliver_to" name="deliver_to">
              <option value="" disabled selected>Choose your option</option>
              @foreach($team_members as $team_member)
                <option value="{{$team_member->app_code}}">{{$team_member->app_lname}}, {{$team_member->app_fname}}</option>
              @endforeach
            </select>
            <label for="deliver_to">Deliver To:</label>
          </div>
        </div>
      </div>
      <!-- End: Basic Details -->

      <div class="row">
        <div class="col l10">
          <div class="divider">
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="row section">
        <div class="col l10">
          <table class="responsive-table" id="table_items">
          <thead class="">
          <tr>
              <th data-field="item_count" class="index center-align">
                 #
              </th>
              <th data-field="item_qty" class="index center-align">
                 QTY
              </th>
              <th data-field="item_unit" class="center-align">
                 UNIT
              </th>
              <th data-field="item_unit_price" class="center-align">
                 UNIT PRICE
              </th>
              <th data-field="item_amount" class="center-align">
                 Amount
              </th>
              <th data-field="item_description" class="center-align">
                 Description
              </th>
              <th data-field="item_budget" class="center-align">
                 Budget
              </th>
              <th data-field="item_dept_proj" class="center-align">
                Dept/Project
              </th>
              <th data-field="item_acct_name" class="center-align">
                 ACCT Name
              </th>
              <th data-field="item_cost_code" class="center-align">
                 COST CODE
              </th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td><input type="text" name="item_qty" value=""/></td>
              <td>
                <select id="item_unit" name="deliver_to">
                  <option value="" disabled selected>Choose your option</option>
                  @foreach($item_units as $unit)
                    <option value="{{$unit->unit_code}}">{{$unit->unit_symbol}}</option>
                  @endforeach
                </select>
                <label for="item_unit">Deliver To:</label>
              </td>
              <td><input type="text" name="item_qty" value=""/></td>
              <td><input type="text" name="item_unit" value=""/></td>
              <td><input type="text" name="item_qty" value=""/></td>
              <td><input type="text" name="item_unit" value=""/></td>
              <td><input type="text" name="item_qty" value=""/></td>
              <td><input type="text" name="item_unit" value=""/></td>
              <td><input type="text" name="item_unit" value=""/></td>
            </tr>
          </tbody>
          </table>
          <div class="section right" id="add_row"><a class="waves-effect waves-light btn"><i class="small material-icons">add</i></a></div>
        </div>
      </div>
      <!-- End: Table -->

      <div class="row">
        <div class="col l10">
          <div class="divider">
          </div>
        </div>
      </div>

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

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    
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


    //RFC, QAC and RFR (Forfeiture)  Filing: Handler for Project Name Dropdown and populating the Approvers' table thereafter
    //RFC Filing: Handler for Project Name Dropdown and populating the RFC REF dropdown thereafter
    $('#project_type').change(function(){
      getToken();
      filing_type = $('input[name="filing_type"]').val();

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
        method: 'POST',
        data: {'project_code' :$('#project_type').val(), 'filing_type': $('input[name="filing_type"]').val(), 
               'request_type_code': request_type_code, '_token': $('meta[name="csrf-token"]').attr('content') },
        success: function(data){
            populateApproversTable(data);
        }
      });
    });

    //Add row for request table
    var rowCounter = 2;
    var table_units;
    $( "#add_row" ).click(function() {
      itemsPointer = $("#table_items tbody");

      if(!table_units)
      {
        $.ajax({
        url: '{{route("unit.index")}}',
        method: 'GET',
        data:{},
        success: function(data){
            table_units = data;
          }
        });
      }

      itemsPointer.append(
                      $("<tr></tr>").html($("<td></td>").attr("value",rowCounter).text(rowCounter++))
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_qty") ) )
                                    .append( $("<td></td>").html( $("<option></option>").attr("name","item_unit").attr("value","item_unit") ) )
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_unit_price") ) )
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_amount") ) )
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_description") ) )
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_budget") ) )
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_dept_proj") ) )
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_acct_name") ) )
                                    .append( $("<td></td>").html( $("<input>").attr("type","text").attr("name","item_cost_code") ) )
                      );
      $('#yourSelectBoxId').append(new Option('optionName', 'optionValue'));

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

  });
</script>
@stop