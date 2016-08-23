<div id="modal_rfc_request_reference" class="modal">
  <div class="modal-content">
    <h5>Reference Number (RFC):</h5>
      <select id="rfc_request_reference">
        <option value="" disabled selected>Choose your option</option>
          @foreach($granted_request_types as $request_type)
            <option value="{{$request_type->req_code}}.{{$request_type->project_no}}.{{$request_type->req_desc}}">
                    {{$request_type->req_code}} - {{$request_type->req_desc}} - {{$request_type->project_no}}
            </option>
          @endforeach
      </select>
      <label>Project Name</label>
      <!-- Table of RFC Reference Numbers -->
      <div class="row">
        <div class="col l10">
          <table class="responsive-table" id="table_rfc_request_reference">
          <thead class="">
          <tr>
            <th data-field="rfc_request_reference_code" class="index center-align">
               RFC Reference Code
            </th>
            <th data-field="rfc_request_reference_owners_name" class="center-align">
               Owner's Name
            </th>
            <th data-field="rfc_request_reference_lot_code" class="center-align">
               Lot Code
            </th>
            <th data-field="rfc_request_reference_add" class="center-align">
               Add
            </th>
          </tr>
          </thead>
          <tbody class="center-align">
          </tbody>
          </table>
        </div>
      </div>
      <!-- End: Table of RFC Reference Numbers -->
      <div class="row">
        <div class="col l10 center">
          <div class="preloader-wrapper big active">
             <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                   <div class="circle"></div>
                </div>
                <div class="gap-patch">
                   <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                   <div class="circle"></div>
                </div>
             </div>
          </div>
        </div>
      </div>
      <div class="align-right">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Back</a>
      </div>
  </div>
</div>
