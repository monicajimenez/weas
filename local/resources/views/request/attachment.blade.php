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
            <a href="{{ route('download', ['attachment_code' => $attachment->att_code]) }}">Download Attachment</a>
            @if(session('user_id') == $attachment->app_code))
              <a href="#">Delete Attachment</a>
            @endif
          </div>
        </div>  
      @endforeach
    </div>
    <div style="clear:both;">
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Back</a>
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Upload Attachment</a>
    </div>
  </div>
</div>