@extends("layouts/master")
@section('sitetitle',  $request_status_label)
@section('pagetitle', $request_status_label)
@section("content")
<div class="row">
  <div class="col s12 m12">

    <!-- View Error -->
    <div class="row">
      <div class="col s12 m12">
        @if($errors->any())
            @foreach($errors->all() as $error)
              <p class="errors">{{$error}}</p>
            @endforeach
         @endif
      </div>
    </div>
     <!-- End: View Error -->
     
    <!-- Search Field -->
    @if ($requests->count()>0 || Input::get('search'))
    <div class="row">
      <div class="col s12 m3 right">
        <form action="{{ route('request.index', ['request_status' => $request_status]) }}" method="get">
          <div class="input-field">
            <input type="search" id="search-field" class="field" required maxlength="" name="search">
            <label for="search-field"><i class="mdi-action-search"></i></label>
            <i class="mdi-navigation-close close"></i>
          </div>
        </form>
      </div>
    </div>
    @endif
    <!-- End: Search Field -->

    <!-- Requests Table -->
    <div class="row">
      <div class="col s12 m10 right">
        @if ($requests->count()>0)
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
               <!--  <th data-field="request_type" class="center-align">
                   Request Type
                </th> -->
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
              @foreach ($requests as $request)
                <tr>
                  <td>{{ trim($request->rfc_code) }}</td>
                  <td>{{ trim($request->rfc_name) }}</td>
                  <td>{{ trim($request->project_no) }}</td>
                  <td>{{ trim($request->lot_no) }}</td>
                  <td>{{ trim($request->rfc_scheme) }}</td>
                  <td>
                    @if($request->rfc_alertdate)
                      {{ date('m/d/Y', strtotime(trim($request->rfc_alertdate))) }}
                    @endif
                  </td>
                  <td>
                    @if($request->rfc_DOR)
                      {{ date('m/d/Y', strtotime(trim($request->rfc_DOR))) }}
                    @endif
                  </td>
                  @if ( isset($request_table_status_column) && $request_table_status_column == 1 )
                    <td>{{ trim($request->rfc_stat) }}</td>
                  @endif
                  <td>
                    <a href="{{ route('request.show', trim($request->rfc_code) ) }}">View</a>
                    <!-- <a class="modal-trigger" href="#modal_remarks">Approve</a> -->
                  <!-- <a href="#">Approve</a><a href="#">Hold</a><a href="#">Deny</a> --></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="center-align">No requests found.</div>
        @endif
      </div>
    </div>
    <!-- End: Requests Table -->

    <!-- Pagination -->
    <div class="row">
      <div class="col s12 m10 right">
        <ul class="pagination right">
          <?php echo $requests->render(); ?>
        </ul>
      </div>
    </div>
    <!-- Pagination -->
  </div>
  @include("request/modal_remarks")
</div>
@stop