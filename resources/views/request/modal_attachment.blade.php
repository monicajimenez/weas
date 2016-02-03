<div class="attachments">
  <div id="modal_attachments" class="modal">
    <div class="modal-content">
    <h5>Attachments:</h5>
      @if(!is_null($details->attachments) && count($details->attachments) <= 0)
        No attachments.
      @endif
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
            <a href="{{ route('attachment.show', ['attachment_code' => trim($attachment->att_code)]) }}"  target="_blank">View Attachment</a>
            <a href="{{ route('attachment.download', ['attachment_code' => trim($attachment->att_code)]) }}">Download Attachment</a>
            @if(trim(Auth::user()->app_code) == trim($attachment->app_code))
              <a href="{{ route('attachment.delete', ['attachment_code' => trim($attachment->att_code)]) }}">Delete Attachment</a>
            @endif
          </div>
        </div>  
      @endforeach
    </div>
    <div style="clear:both;">
    </div>
    <form action="{{ route('attachment.upload') }}" files="true" enctype="multipart/form-data" method="post">
      <div class="modal-footer">
        <h5>Upload Attachment</h5>
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

        <input type="file" name="upload_attachment" value="Upload attachment"></input>
        <input type="hidden" name="request_id" value="{{trim($details->rfc_code)}}"></input>
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Back</a>
        <button type="submit" id="upload_attachment" class=" modal-action modal-close waves-effect waves-green btn-flat">Upload Attachment</button>
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"></input>
      </div>
    </form>
  </div>
</div>