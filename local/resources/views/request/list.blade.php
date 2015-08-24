@extends("layouts/master")
@section('sitetitle',  $request_status_label)
@section('pagetitle', $request_status_label)
@section("content")
<div class="row">
  <div class="col s12 m12">
    <!-- Search Field -->
    <div class="row">
      <div class="col s12 m3 right">
        <form>
          <div class="input-field">
            <input type="search" id="search-field" class="field" required maxlength="">
            <label for="search-field"><i class="mdi-action-search"></i></label>
            <i class="mdi-navigation-close close"></i>
          </div>
        </form>
      </div>
    </div>
    <!-- End: Search Field -->

    <!-- Requests Table -->
    <div class="row">
      <div class="col s12 m10 right">
        <table class="responsive-table hoverable">
          <thead class="">
            <tr>
              <th data-field="code" class="center-align">
                 Code
              </th>
              <th data-field="owners_name" class="center-align">
                 Owner's Name
              </th>
              <th data-field="project_name" class="center-align">
                 Project Name
              </th>
              <th data-field="lot_code" class="center-align">
                 Lot Code
              </th>
              <th data-field="request_type" class="center-align">
                 Request Type
              </th>
              <th data-field="payment_scheme" class="center-align">
                 Payment Scheme
              </th>
              <th data-field="qualification_date" class="center-align">
                 Qualification Date
              </th>
              <th data-field="date_filed" class="center-align">
                 Date Filed
              </th>
              @if( isset($request_table_status_column) && $request_table_status_column == 1 )
              <th data-field="status" class="center-align">
                 Status
              </th>
              @endif
              <th data-field="actions" class="center-align">
                 Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                 QAC-163
              </td>
              <td>
                 Melvin Lopez Baldonasa
              </td>
              <td>
                 RIVERSIDE2
              </td>
              <td>
                 AJ240
              </td>
              <td>
                 Qualified Accounts for Construction
              </td>
              <td>
                 20% over 18, 80% spot or bank
              </td>
              <td>
                 April 12, 2012
              </td>
              <td>
                 April 12, 2012
              </td>
              @if( isset($request_table_status_column) && $request_table_status_column == 1 )
              <td>
                 Pending
              </td>
              @endif
              <td>
                <a href="{{ route('request::details') }}">View</a><a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a>
              </td>
            </tr>
            <tr>
              <td>
                 QAC-163
              </td>
              <td>
                 Melvin Lopez Baldonasa
              </td>
              <td>
                 RIVERSIDE2
              </td>
              <td>
                 AJ240
              </td>
              <td>
                 Qualified Accounts for Construction
              </td>
              <td>
                 20% over 18, 80% spot or bank
              </td>
              <td>
                 April 12, 2012
              </td>
              <td>
                 April 12, 2012
              </td>
              @if( isset($request_table_status_column) && $request_table_status_column == 1 )
              <td>
                 Pending
              </td>
              @endif
              <td>
                <a href="{{ route('request::details') }}">View</a><a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a>
              </td>
            </tr>
            <tr>
              <td>
                 QAC-163
              </td>
              <td>
                 Melvin Lopez Baldonasa
              </td>
              <td>
                 RIVERSIDE2
              </td>
              <td>
                 AJ240
              </td>
              <td>
                 Qualified Accounts for Construction
              </td>
              <td>
                 20% over 18, 80% spot or bank
              </td>
              <td>
                 April 12, 2012
              </td>
              <td>
                 April 12, 2012
              </td>
              @if( isset($request_table_status_column) && $request_table_status_column == 1 )
              <td>
                 Pending
              </td>
              @endif
              <td>
                <a href="{{ route('request::details') }}">View</a><a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a>
              </td>
            </tr>
            <tr>
              <td>
                 QAC-163
              </td>
              <td>
                 Melvin Lopez Baldonasa
              </td>
              <td>
                 RIVERSIDE2
              </td>
              <td>
                 AJ240
              </td>
              <td>
                 Qualified Accounts for Construction
              </td>
              <td>
                 20% over 18, 80% spot or bank
              </td>
              <td>
                 April 12, 2012
              </td>
              <td>
                 April 12, 2012
              </td>
              @if( isset($request_table_status_column) && $request_table_status_column == 1 )
              <td>
                 Pending
              </td>
              @endif
              <td>
                <a href="{{ route('request::details') }}">View</a><a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a>
              </td>
            </tr>
            <tr>
              <td>
                 QAC-163
              </td>
              <td>
                 Melvin Lopez Baldonasa
              </td>
              <td>
                 RIVERSIDE2
              </td>
              <td>
                 AJ240
              </td>
              <td>
                 Qualified Accounts for Construction
              </td>
              <td>
                 20% over 18, 80% spot or bank
              </td>
              <td>
                 April 12, 2012
              </td>
              <td>
                 April 12, 2012
              </td>
              @if( isset($request_table_status_column) && $request_table_status_column == 1 )
              <td>
                 Pending
              </td>
              @endif
              <td>
                <a href="{{ route('request::details') }}">View</a><a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a>
              </td>
            </tr>
            <tr>
              <td>
                 QAC-163
              </td>
              <td>
                 Melvin Lopez Baldonasa
              </td>
              <td>
                 RIVERSIDE2
              </td>
              <td>
                 AJ240
              </td>
              <td>
                 Qualified Accounts for Construction
              </td>
              <td>
                 20% over 18, 80% spot or bank
              </td>
              <td>
                 April 12, 2012
              </td>
              <td>
                 April 12, 2012
              </td>
              @if( isset($request_table_status_column) && $request_table_status_column == 1 )
              <td>
                 Pending
              </td>
              @endif
              <td>
                <a href="{{ route('request::details') }}">View</a><a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- End: Requests Table -->

    <!-- Pagination -->
    <div class="row">
      <div class="col s12 m10 right">
        <ul class="pagination right">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li class="active"><a href="#!">1</a></li>
          <li class="waves-effect"><a href="#!">2</a></li>
          <li class="waves-effect"><a href="#!">3</a></li>
          <li class="waves-effect"><a href="#!">4</a></li>
          <li class="waves-effect"><a href="#!">5</a></li>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
      </div>
    </div>
    <!-- Pagination -->
  </div>
</div>
@stop