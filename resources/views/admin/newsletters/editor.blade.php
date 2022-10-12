<div class="page-inner">
    <div class="page-header mb-4">
        <h4 class="page-title">{{ __('Send Newsletter Mail') }}</h4>

    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif

            <div class="card">
                <div class="card-body">
                  <input type="hidden" name="action" id="action" value="{{ route('admin.newsletters.send') }}">
                    @if ($users)
                        <div class="form-group">
                            <label for="">{{ __('Users') }}</label>
                            <div class="clear"></div>
                            @foreach ($users as $user)
                                <span class="badge badge-secondary">{{ $user->email }}</span>
                                <input type="hidden" name="emails[]" value="{{ $user->email }}" class="emails">
                            @endforeach
                        </div>
                    @elseif($subscribers)
                    <div class="form-group">
                        <label for="">{{ __('Subscribers') }}</label>
                        <div class="clear"></div>
                        @foreach ($subscribers as $sub)
                            <span class="badge badge-secondary">{{ $sub->email }}</span>
                            <input type="hidden" name="emails[]" value="{{ $sub->email }}" class="emails">
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="">{{ __('Subject') }}</label>
                        <input type="text" class="form-control" id="subject">
                    </div>
                    <textarea name="content" id="content" class="editor"></textarea>
                </div>
            </div>
            <button class="btn btn-success submit mt-4 float-right" type="button"><b><i class="fas fa-paper-plane"></i> {{ __('Send Email') }}</b></button>


        </div>
    </div>
</div>
<div class="sending-wrapper d-none">
    <img src="{{ url('backend/img')."/main-sending.gif" }}" alt="">
    <h1 class="text-warning counter"> <b>0</b> / <span>0</span> </h1>
    <p>{{ __('Please do not close this window while sending mail.') }}</p>
    <small class="text-danger d-none">{{ __('Undeliverable') }} : <b>0</b></small>
</div>

<script type="text/javascript">
var i = 0;
var e = 0;
  $('.submit').click(function(){
    sendEmail(this, i)
    $('.sending-wrapper').removeClass('d-none')
  })

  function sendEmail(elmu, h = 0){
    var emails = []
    $('.emails').each(function(i, item){
      emails.push($(item).val())
    })
    $('.sending-wrapper').find('.counter').find('span').text(emails.length)
    if(emails[h]){
      var elm = $(elmu)
      var content = tinymce.get("content").getContent();
      var subject = $('#subject').val();
      var action = $('#action').val();
      var data = {'email' : emails[h], 'subject': subject, 'content': content, '_token': '{{ csrf_token() }}'}
      console.log(data);
      if(!emails[h] || !content || !subject){
        return false;
      }
      $.post(action, data, function(response){
        if(response && response.message == 'sent'){
          i++;
          $('.sending-wrapper').find('.counter').find('b').text(i)
          sendEmail(elmu, i)
        } else {
          e++;
          i++;
          $('.sending-wrapper').find('.counter').find('b').text(i)
          $('.sending-wrapper').find('.text-danger').removeClass('d-none')
          $('.sending-wrapper').find('.text-danger').find('b').text(e)
          sendEmail(elmu, i)
        }
      })
    } else {
      $('.sending-wrapper').find('b').text(i)
      setTimeout(function(){
        $('.sending-wrapper').addClass('d-none')
        location.href = '{{ route('admin.newsletters.index') }}'
      }, 1000)
    }

  }
</script>
