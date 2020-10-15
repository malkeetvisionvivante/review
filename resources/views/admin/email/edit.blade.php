@extends('admin.admin_layout.admin_app')
@section('content')
@if ($errors->any())
<?php toastr()->error('Something went wrong!!'); ?>
@endif
<style type="text/css">
	.error-message {
    color: red;
}
</style>
     <div class="inner-container">
        <div class="card-header py-3">
              <div class="row">
                <div class="col-12">
	                 <h3 class="m-0 font-weight-bold text-primary">Update Template</h3>
	            </div>
	          </div>    
            </div>
            <div class="card-body">
              <form class="user mainform" name="add-user" action="{{ url('admin/email/edit/'.$data->id)}}" method="post">
               @csrf
                <div class="form-group row">
                  <div class="col-sm-12 mb-sm-0">
                  <label>Subject*</label>
                    <input type="text" name="subject" value="{{ old('subject',$data->subject)}}" class="form-control @error('subject') is-invalid @enderror" id="subject" placeholder="Subject">
                    @error('subject')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{str_replace('subject', 'Subject', $message)}}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-sm-12">
                  <label>From</label>
                    <input type="text" name="from" value="{{ old('from',$data->from)}}" class="form-control  @error('from') is-invalid @enderror" id="from" placeholder="From">
                    @error('from')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{str_replace('from', 'From', $message)}}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-sm-12">
                  <label>Reply</label>
                    <input type="text" name="reply" value="{{ old('reply',$data->reply)}}" class="form-control  @error('reply') is-invalid @enderror" id="reply" placeholder="Reply">
                    @error('reply')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{str_replace('reply', 'Reply', $message)}}</strong>
                        </span>
                    @enderror
                  </div>
                </div>  	
                <div class="form-group row">
                  <div class="col-sm-12">
                   <label>Body</label>
	                  <textarea name="content" class="form-control" id="content_data" cols="10" rows="10">{{$data->content}}</textarea>
	                   @error('content')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message}}</strong>
                        </span>
                    @enderror
                   </div>  

                </div>   
                <div class="form-group row">
                  <div class="col-sm-12">
                	<button type="submit" style="float: right;" class="btn btn-primary m-1">Update</button>
                	<a href="#" data-toggle="modal" data-target="#add_question" class="btn btn-success round-shape">Test</a>
                </div>
                </div>	
              </form> 
            </div>            
            </div>
            <div class="modal fade" id="add_question">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Test Email Template</h4>
        <form class="send-email" method="post" action="{{ url('admin/email/testemail')}}">
          @csrf
          <div class="form-group">
            <label>Recipient Email</label>
            <input type="text" placeholder="Email" class="form-control" name="testemail" required="">
            <input type="hidden" value="{{$data->subject}}" name="testsubject">
            <input type="hidden" value="{{$data->content}}" name="testbody">
            <input type="hidden" value="{{$data->id}}" name="testid">
          </div>
          <button type="submit" class="btn btn-success round-shape">Send Email</button>
        </form>
      </div>
    </div>
  </div>
</div>
          </div>

@endsection
@section('scripts')
 <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
 <script type="text/javascript">
    jQuery('.mainform').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            subject:{
                required:true,
            },
            from:{
                required:true,
            },
            reply:{
                required:true,
            },
            content:{
                         required: function() 
                        {
                         CKEDITOR.instances.content_data.updateElement();
                        },

                         minlength:10
                    }
          }      
      });
    //  editor = CKEDITOR.replace( 'content_data' );
    //  editor.addCommand("mySimpleCommand", {
    //     exec: function(edt) {
    //       editor.insertHtml( '[lang_ru]' );
    //       }
    //   });
    //   editor.ui.addButton('Mynhm', {
    //       label: "Click me",
    //       command: 'mySimpleCommand',
    //       toolbar: 'about',
    //       icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
    //   });

    CKEDITOR.replace( 'content_data', {   
    on: {
        pluginsLoaded: function() {
            var editor = this,
                config = editor.config;

            editor.ui.addRichCombo( 'my-combo', {
                label: 'Details',
                title: 'Details',
                toolbar: 'styles',

                panel: {               
                    css: [ CKEDITOR.skin.getPath( 'editor' ) ].concat( config.contentsCss ),
                    multiSelect: false,
                    attributes: { 'aria-label': 'Details' }
                },

                init: function() {    
                    this.startGroup( 'Details' );
                    this.add( '[FName]', 'First Name' );
                    this.add( '[LName]', 'Last Name' );                                
                    this.add( '[Contact]', 'Contact' );                                
                    this.add( '[Address]', 'Address' );                                
                },

                onClick: function( value ) {
                    editor.focus();
                    editor.fire( 'saveSnapshot' );
                    editor.insertHtml( value );
                    editor.fire( 'saveSnapshot' );
                }
            } );        
        }        
    },
    filebrowserUploadUrl: <?php echo json_encode(url('admin/email/upload?_token='.csrf_token())) ?>,
    filebrowserUploadMethod: 'form'
} );
 </script>
@endsection 
