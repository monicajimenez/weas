<div class="attachments">
  <div id="modal_attachments" class="modal">
    <div class="modal-content">
      @foreach($details->attachments as $attachment)
        <div class="card">
          <div class="card-image center-align">
            <i class="medium material-icons">perm_media</i>
            <span class="card-title"></span>
          </div>
          <div class="card-content">
            <p>
              {{ $attachment->att_name }}
            </p>
          </div>
          <div class="card-action">
            <a href="{{ route('attachment.download', ['attachment_code' => $attachment->att_code]) }}">Download Attachment</a>
            @if(session('user_id') == $attachment->app_code))
              <a href="#">Delete Attachment</a>
            @endif
          </div>
        </div>  
      @endforeach
    </div>
    <div style="clear:both;">
    </div>
    <form action="{{ route('attachment.upload') }}" files="true" enctype="multipart/form-data" method="post">
      <div class="modal-footer">
        <input type="hidden" name="request_id" value="{{trim($details->rfc_code)}}"></input>
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Back</a>
        <input type="file" name="upload_attachment" value="Upload attachment"></input>

        <p>
          <input class="with-gap" name="attachment_type[]" value ="Code-001" type="radio" id="purchase_order" />
          <label for="purchase_order">Purchase Order</label>
        </p>
        <p>
          <input class="with-gap" name="attachment_type[]" value="Code-002" type="radio" id="bank_guaranty" />
          <label for="bank_guaranty">Bank Guaranty</label>
        </p>
        <p>
          <input class="with-gap" name="attachment_type[]" value="Code-004" type="radio" id="house_layout"  />
          <label for="house_layout">House Layout</label>
        </p>
        <p>
            <input class="with-gap" name="attachment_type[]" value="Code-003" type="radio" id="file" checked/>
            <label for="file">File</label>
        </p>

        <button type="submit" class=" modal-action modal-close waves-effect waves-green btn-flat">Upload Attachment</button>
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"></input>
      </div>
    </form>
  </div>
</div>