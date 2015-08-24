@extends("layouts/master")
@section('sitetitle', 'Request Details')
@section('pagetitle', 'Request Details')
@section("content")
<div class="row">
  <div class="col s11 m10 right">
    <form>
      <!-- Basic and Project Details -->
      <div class="row">
        <div class="col s10 m5">
          <h5>Basic Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input id="qac_code" type="text" class="validate">
              <label for="qac_code">QAC Code</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="date_filed" type="text" class="validate">
              <label for="date_filed">Date Filed</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="date_qualified" type="text" class="validate">
              <label for="date_qualified">Date Qualified</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="owners_name" type="text" class="validate">
              <label for="owners_name">Owner's Name</label>
            </div>
          </div>
        </div>
        <div class="col s10 m5 padding-left-25 hide-on-small-only">
          <h5>Project Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input id="project" type="text" class="validate">
              <label for="project">Project</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="cotract_amount" type="text" class="validate">
              <label for="cotract_amount">Contract Amount</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="lot_code" type="text" class="validate">
              <label for="lot_code">Lot Code</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="lot_area" type="text" class="validate">
              <label for="lot_area">Lot Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="floor_area" type="text" class="validate">
              <label for="floor_area">Floor Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="house_model" type="text" class="validate">
              <label for="house_model">House Model</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="payment_scheme" type="text" class="validate">
              <label for="payment_scheme">Payment Scheme</label>
            </div>
          </div>
        </div>
        <div class="col s10 m5 hide-on-med-and-up">
          <h5>Project Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input id="project" type="text" class="validate">
              <label for="project">Project</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="cotract_amount" type="text" class="validate">
              <label for="cotract_amount">Contract Amount</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="lot_code" type="text" class="validate">
              <label for="lot_code">Lot Code</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="lot_area" type="text" class="validate">
              <label for="lot_area">Lot Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="floor_area" type="text" class="validate">
              <label for="floor_area">Floor Area</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="house_model" type="text" class="validate">
              <label for="house_model">House Model</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="payment_scheme" type="text" class="validate">
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
              <input id="bank_name" type="text" class="validate">
              <label for="bank_name">Bank Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="approved_amount" type="text" class="validate">
              <label for="approved_amount">Approved Amount</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="turnover_date" type="text" class="validate">
              <label for="turnover_date">Turnover Date</label>
            </div>
          </div>
        </div>
        <div class="col s10 m5 padding-left-25 hide-on-small-only">
          <h5>NOA Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input id="noa_number" type="text" class="validate">
              <label for="noa_number">NOA Number</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="contractor" type="text" class="validate">
              <label for="contractor">Contractor</label>
            </div>
          </div>
        </div>
        <div class="col s10 m5 hide-on-med-and-up">
          <h5>NOA Details:</h5>
          <div class="row">
            <div class="input-field col s12">
              <input id="noa_number" type="text" class="validate">
              <label for="noa_number">NOA Number</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="contractor" type="text" class="validate">
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
          <tr>
            <td>
              1
            </td>
            <td>
              Prepared by
            </td>
            <td>
              Elizabeth Oropesa
            </td>
            <td>
              Account Management Associate
            </td>
            <td>
              Signed
            </td>
            <td>
              with signed RA and IES
            </td>
          </tr>
          <tr>
            <td>
              2
            </td>
            <td>
              Verified by
            </td>
            <td>
              Heidi Odchigue
            </td>
            <td>
              Manager, Project Development Team
            </td>
            <td>
              Signed
            </td>
            <td>
              ok with signed house layout
            </td>
          </tr>
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
      <!-- Attachments and Remarks -->
      <div id="remarks" class="row">
        <div class="col s10 m10">
          <h5>Remarks:</h5>
          <div class="row">
            <div class="input-field col s12 m10">
              <textarea id="remarks" class="materialize-textarea"></textarea>
              <label for="remarks">Input remarks.</label>
            </div>
          </div>
        </div>
      </div>
      <!-- End: Attachments and Remarks -->
      <!-- Buttons-->
      <div class="fixed-action-btn" style="bottom: 80px;">
        <a class="btn-floating btn-large">
        <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
          <li><a class="btn-floating btn-small waves-effect waves-light modal-trigger" href="#modal_attachments"><i class="material-icons">description</i></a></li>
          <li><a class="btn-floating btn-small waves-effect waves-light red"><i class="material-icons">thumb_down</i></a></li>
          <li><a class="btn-floating btn-small waves-effect waves-light yellow"><i class="material-icons">pause_circle_outline</i></a></li>
          <li><a class="btn-floating btn-small waves-effect waves-light green"><i class="material-icons">thumb_up</i></a></li>
        </ul>
      </div>
      <!-- End: Buttons-->
      <!-- Modal Structure -->
      <div class="attachments">
        <div id="modal_attachments" class="modal">
          <div class="modal-content">
            <div class="card">
              <div class="card-image center-align">
                <i class="medium material-icons">perm_media</i>
                <span class="card-title"></span>
              </div>
              <div class="card-content">
                <p>
                  FloorPlan.docx
                </p>
              </div>
              <div class="card-action">
                <a href="#">Download Attachment</a>
                <a href="#">Delete Attachment</a>
              </div>
            </div>
            <div class="card">
              <div class="card-image center-align">
                <i class="medium material-icons">perm_media</i>
                <span class="card-title"></span>
              </div>
              <div class="card-content">
                <p>
                  FloorPlan.docx
                </p>
              </div>
              <div class="card-action">
                <a href="#">Download Attachment</a>
                <a href="#">Delete Attachment</a>
              </div>
            </div>
          </div>
          <div style="clear:both;">
          </div>
          <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Back</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Upload Attachment</a>
          </div>
        </div>
      </div>
      <!-- End: Modal Structure -->
    </form>
  </div>
</div>
@stop