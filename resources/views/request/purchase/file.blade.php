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
      <div class="row">

        <div class="col l10 section right">
          <div class="row">
            <div class="input-field col l2 right">
              <input name="input_request_type_code" type="text" class="validate" value="" disabled>
              <label for="label_request_type_code">Request Code</label>
            </div>
            <div class="input-field col l2 right">
              <input name="date_filed" type="text" class="validate" value="{{date('M d, Y')}}" disabled>
              <input name="date_filed" type="hidden" class="validate" value="{{date('M d, Y')}}">
              <label for="date_filed">Date Filed</label>
            </div>
          </div>
        </div>

        <div class="col l10 section left">
          <div class="row">
            <div class="input-field col l2 left">
              <select id="id_dd_pr_request_type" name="name_dd_pr_request_type">
                <option value="" disabled selected>Choose your option</option>
                @foreach($data_pr_request_types as $data_pr_request_type)
                  <option value="{{$data_pr_request_type->req_code}}">{{$data_pr_request_type->req_desc}}</option>
                @endforeach
              </select>
              <label for="label_dd_pr_request_type">PR Request Type</label>
            </div>
            <div class="input-field col l2 left">              
              <input name="input_amount" type="text" class="validate" value="">
              <label for="label_amount">Amount</label>
            </div>
            <!-- Charge to: Commented out. Business might include. -->
            <!-- <div id="id_container_charge_to">
              <div class="input-field col l2 left">
                <select id="id_charge_to" name="name_dd_charge_to">
                  <option value="" disabled selected>Choose your option</option>
                  <option value="team">Team</option>
                  <option value="project">Project</option>
                </select>
                <label for="label_dd_charge_to">Charge To</label>
              </div>
              <div id="id_charge_to_team" class="input-field col l2 left">
                <select name="name_dd_charge_to_team">
                  <option value="" disabled selected>Choose your option</option>
                  @foreach($data_charge_to_teams as $data_charge_to_team)
                    <option value="{{$data_charge_to_team->dept_code}}">{{$data_charge_to_team->dept_name}}</option>
                  @endforeach
                </select>
                <label for="label_dd_charge_to_team">Team:</label>
              </div>
              <div id="id_charge_to_project" class="input-field col l2 left">
                <select name="name_dd_charge_to_project">
                  <option value="" disabled selected>Choose your option</option>
                  @foreach($data_charge_to_projects as $data_charge_to_project)
                    <option value="{{$data_charge_to_project->project_no}}">{{$data_charge_to_project->project_desc}}</option>
                  @endforeach
                </select>
                <label for="label_dd_charge_to_project">Project:</label>
              </div>
            </div> -->
            <!-- End: Charge to -->
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

      <!-- PDF -->
      <div class="row section">
        <div class="col l10 center-align">
          <h5>PDF HERE</h5>
        </div>
      </div>
      <!-- End: PDF -->

      <div class="row">
        <div class="col l10">
          <div class="divider">
          </div>
        </div>
      </div>

      <!-- Quote -->
      <div class="row section">
        <div class="col l10 center-align">
          <h5>Quote HERE</h5>
        </div>
      </div>
      <!-- End: Quote -->

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
          <table class="responsive-table" id="id_table_approvers">
          <thead >
          <tr>
            <th data-field="th_app_closing" class="center-align">
               Closing
            </th>
            <th data-field="th_app_name" class="center-align">
               Name
            </th>
            <th data-field="th_app_pos" class="center-align">
               Position
            </th>
            <th data-field="th_app_date_approved" class="center-align">
               Date Approved
            </th>
          </tr>
          </thead>
            <tbody class="center-align">
            <tr>
              <td class="center-align">Requested by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
            <tr>
              <td class="center-align">Approved by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
            <tr>
              <td class="center-align">Reviewed by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
            <tr>
              <td class="center-align">Approved by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
            <tr>
              <td class="center-align">Approved by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
            <tr>
              <td class="center-align">Approved by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
            <tr>
              <td class="center-align">Approved by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
            <tr>
              <td class="center-align">Approved and Released by:</td>
              <td class="center-align">Sample Name here</td>
              <td class="center-align">Position here</td>
              <td class="center-align">Date here</td>
            </tr>
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

      <!-- End: RFR Forfeiture Reminder -->

      <!-- Remarks -->
      @include("request.includes_remarks")
      <!-- End: Remarks -->

      <!-- Modal Includes -->
      <!-- INCLUDE MODAL HERE ONCE DATA IS ON -->
      <!-- End: Modal Includes -->

      <!-- Buttons-->
      <div class="fixed-action-btn click-to-toggle" style="bottom: 80px;">
        <a class="btn-floating btn-large">
        <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
          <li><a><button type="button" class="btn-floating btn-small waves-effect waves-light modal-trigger" title="Attachment" href="#modal_attachments"><i class="material-icons">attach_file</i></button></a></li>
          <li><button type="submit" value="Save" title="Save" class="btn-floating btn-small waves-effect waves-light green"><i class="material-icons">done</i></button></li>
          <li><button type="reset" value="Cancel" title="Cancel" class="btn-floating btn-small waves-effect waves-light red"><i class="material-icons">not_interested</i></button></li>
        </ul>
      </div>
      <!-- End: Buttons-->

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#id_charge_to_project').hide();
    $('#id_charge_to_team').hide();

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

    //Request Type Dropdown Handler
    $('#id_dd_pr_request_type').change(function(){
      getToken();
      v_pr_request_type = $(this).val();
      v_filing_type = 'PR';

      $.ajax({
        url: '{{route("getrequesttypeapprovers")}}',
        method: 'POST',
        data: {'project_code' : 'all', 'filing_type': v_filing_type, 'request_type_code': v_pr_request_type ,'_token': $('meta[name="csrf-token"]').attr('content') },
        success: function(data){
             console.log(data);
        }
      });

      console.log('outside ajax');
    });
    

    //Charge To Dropdown Handler
     $('#id_charge_to').change(function(){
        v_charge_to =  $(this).val();

        if(v_charge_to == 'team')
        {
          $('#id_charge_to_project').hide();
          $('#id_charge_to_team').show();
        }
        else
        {
          $('#id_charge_to_team').hide();
          $('#id_charge_to_project').show();
        }
     });

  });
</script>
@stop