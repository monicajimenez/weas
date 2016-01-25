$(document).ready(function(){
  alert();
  $('#rfc_ref_no_container').hide();
  $('#container_modal_add_approver').hide();

  //Function for populating the Approvers' table
  function populateApproversTable(data)
  {
    var newRowContent;

    $('#table_approvers tbody').empty();

    $.each( data, function( key, approver ) {
      newRowContent = "<tr><td class='index center-align'>" + approver["app_level"] + 
                              "<input type='hidden' name='approvers[]' value='"+ approver["app_code"] +"'>" + "</td>" +
                      "<td class='center-align'>" + approver["close_desc"] +
                              "<input type='hidden' name='close_codes[]' value='"+ approver["close_code"] +"'>" +  "</td>" +
                      "<td class='center-align'>" + approver["app_fname"] + " " + approver["app_lname"] + "</td>" +
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
  
    $('#container_modal_add_approver').show();
  }

  //Handler for Add Approver Button below Approvers' Table
  $('#container_modal_add_approver').click(function(){
    $.ajax({
      url: '{{route("user.approver")}}',
      type: 'POST',
      data: {'_token': $('meta[name="csrf-token"]').attr('content')},
      success: function(data){
        var newRowContent;

        $.each( data, function( key, approver ) {
          newRowContent = "<tr><td class='index center-align' id='app_code'>" + approver["app_code"] + "</td>" +
                          "<td class='center-align' id='app_name'>" + approver["app_fname"] + " " + approver["app_lname"] + "</td>" +
                          "<td class='center-align' id='app_position'>" + approver["app_position"] + "</td>" +
                          "<td class='center-align'>" + "<a name='"+ approver["app_code"]+"' class='add_app btn-flat'><i class='tiny material-icons'>add</i></a>" + "</td>";

          $("#add_table_approvers tbody").append(newRowContent);
        });
      }
    });  
  });
  
  //QAC and RFR (Forfeiture)  Filing: Handler for Project Name Dropdown and populating the Approvers' table thereafter
  $('#project_type').change(function(){
    if( $('input[name="filing_type"]').val() != 'RFC')
    {
      request_code = '';

      if($('input[name="filing_type"]').val() == 'RFR')
      {
        request_code = 'Req-027'; //request_code for Forfeitures
      }
      if($('input[name="filing_type"]').val() == 'QAC')
      {
        request_code = 'Req-021'; //request_code for QAC
      }

      $.ajax({
      url: '{{route("getrequesttypeapprovers")}}',
      type: 'POST',
      data: {'project_code' :$('#project_type').val(), 'filing_type': $('input[name="filing_type"]').val(), 'request_code': request_code, '_token': $('meta[name="csrf-token"]').attr('content') },
      success: function(data){
          populateApproversTable(data);
      }
    });
    }                  
  });

  //RFR (Request for Change) Filing: Handler for RFC Request Reference Dropdown and Populating of RFCs Table thereafter
  $('#rfc_request_reference').change(function(){
    var data = $('#rfc_request_reference').val().split('.');
    var request_code = data[0];
    var project_no = data[1];
      $.ajax({
        url: '{{route("getRFCRequestReferences")}}',
        type: 'POST',
        data: {'request_code' : request_code, 'project_no': project_no, '_token': $('meta[name="csrf-token"]').attr('content') },
        success: function(data){
            $('#table_rfc_request_reference tbody').empty();

            $.each( data, function( key, rfc_ref ) {
              newRowContent = "<tr>" +
                              "<td class='index center-align'>" + rfc_ref["rfc_code"] + "</td>" +
                              "<td class='center-align'>" + rfc_ref["rfc_name"] +  "</td>" +
                              "<td class='center-align'>" + rfc_ref["lot_no"] + "</td>" +
                              "<td class='center-align'>" + 
                                "<a id='" + rfc_ref["rfc_code"] + "." + request_code + "." + project_no + "' class='add_rfc_request_referece btn-flat'><i class='tiny material-icons'>add</i></a>" +
                              "</td>"+
                              "</tr>";
              $("#table_rfc_request_reference tbody").append(newRowContent);
            });
        }
      })
  });

  //RFR Filing: Handler for adding of the RFC Code in the form upon user click in the RFC Refs Table and Populating the Approvers' Table
  $('#table_rfc_request_reference').on('click', '.add_rfc_request_referece', function() {
    data = $(this).attr('id').split('.');
    project_code = data[2];
    request_code = data[1];
    filing_type = 'RFR';

    $.ajax({
      url: '{{route("getrequesttypeapprovers")}}',
      type: 'POST',
      data: {'project_code' : project_code, 'filing_type': filing_type, 'request_code': request_code ,'_token': $('meta[name="csrf-token"]').attr('content') },
      success: function(data){
           populateApproversTable(data);
      }
    });

    $('[name=rfc_ref_no]').val($(this).attr('id'));
    $('#btn_modal_rfc_request_reference').hide();
  });

  //RFC Filing: Handler of the Request Type Drop Down under Additional Details
  //Requires that a Project Name be chosen in the Basic Details Area
  $('#req_ref').change(function(){
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
          $(this).html(i + 2);
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
          $(this).html(i + 2);
      });
  });

  $('#add_table_approvers').on('click', '.add_app', function() {
     newRowContent = "<tr><td class='index center-align'>" + " " + "</td>" +
                    "<td class='center-align'>" + "" + "</td>" +
                    "<td class='center-align'>" + $(this).parents('tr').children('#app_name').html() + "</td>" +
                    "<td class='center-align'>" + $(this).parents('tr').children('#app_position').html() + "</td>" +
                    "<td class='center-align'>" + "N" + "</td>" +
                    "<td class='center-align'>" + "<a name='"+ $(this).parents('tr').children('#app_code').html() +"' class='delete_app btn-flat'><i class='tiny material-icons'>delete</i></a>" + "</td>";

    $("#table_approvers tbody").append(newRowContent);
  });

  //TOGGLE FUNCTIONALITIES

  function toogleEvents()
  {
      $('#table_approvers tbody').empty();
      document.getElementById("form_file").reset();
      $('#project_type_container').toggle(); 
      $('#rfc_ref_no_container').toggle();
      $('#forfeiture_reminder_container').toggle();
  }

  $('#request_for_change').click(function(){  
    toogleEvents();
  }); 

  $('#forfeiture').click(function(){  
    toogleEvents();
  }); 

});