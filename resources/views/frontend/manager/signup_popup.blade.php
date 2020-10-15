<div class="modal-tooltip" id="comment_sign_up_popup">
  <div class="modal-header border-0 pb-0">
    <h3 class="mb-0" id="signup_popup_header">Sign up to view feedback</h3>
    <!-- <button type="button" class="close px-2 py-1" id="comment_sign_up_popup_close">×</button> -->
  </div>
  <div class="modal-body p-3 p-md-4">
    <div class="row">
      <div class="col-md-12">
       <form class="comment_signup_form" action="" method="post" id="sign_up_form">
          <div class="input-group">
              <input type="text" class="form-control h-auto" placeholder="Email address" name="email" id="sign_up_email" style="background-color:#ebf3fa;border-color:#c0dbed;"/>
              <div class="input-group-prepend">
                <button type="submit" class="btn btn-success round-shape">Sign me up</button>
              </div>
          </div>
          <div id="sign_up_error"></div>
        </form>

        <form class="comment_signup_form" action="" method="post" id="exist_sign_up_form">
          <div class="form-group">
              <input type="text" class="form-control" placeholder="Email address" name="email" id="exist_sign_up_email"/>
          </div>
           <div class="form-group">
              <input type="password" class="form-control" placeholder="Password" name="password" id="exist_sign_up_password"/>
          </div>
          <div><button type="submit" class="btn btn-success round-shape">Log in</button></div>
        </form>

        <form class="comment_signup_form" action="" method="post" id="not_exist_sign_up_form">
          <div class="form-group">
              <input type="text" class="form-control" placeholder="Email address" name="email" id="not_exist_sign_up_email"/>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" placeholder="First name" name="name" id="not_exist_sign_up_name"/>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" placeholder="Last name" name="last_name" id="not_exist_sign_up_last_name"/>
          </div>
          <div class="form-group">
              <input type="password" class="form-control" placeholder="Password" name="password" id="not_exist_sign_up_password"/>
          </div>
          <div><button type="submit" class="btn btn-success round-shape" id="not_exist_sign_up_button">Sign me up</button></div>
        </form>
        <div id="matched-users-text">
          <h5>Your name is a close match with a profile already in our system. Please select who you are from the below</h5>
          <p class="text-muted mb-3 small">Hint: your anonymity will always be protected. This is just so you can get notifications when someone leaves you a new review or visits your profile!</p>
        </div>
        <div id="matched-users"></div>
        <div id="sign_up_social_login">
        <div class="or--label"><span>Or Sign Up With</span></div>
        <div class="text-center form--multi--buttons-with-circle mb-4">
          <a href="{{ url('/manager-detail-facebook') }}"><i class="fab fa-facebook-f"></i></a>
          <a href="{{ url('/manager-detail-google') }}"><i class="fab fa-google-plus-g"></i></a>
          <a href="{{ url('/manager-detail-linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p class="text-muted mb-0 font-14 text-center">By signing up, you agree to our <a href="{{ url('/terms-conditions') }}">Terms</a>,
          <a href="{{ url('/privacy-policy') }}">Data</a>, <a href="{{ url('/other-policies') }}">Policy</a> and <a href="{{ url('/cookie-policy') }}">Cookies Policy.</a></p>
        <p class="mt-2 font-weight-bold" style="color:#3f7eca;"><i>Already a user?</i> <a href="{{ url('/login-user') }}" style="color:#3f7eca;">Click here to login.</a></p>  
      </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  //   jQuery(document).ready(function($){
  //   $.fn.isInViewport = function () {
  //       var elementTop = $(this).offset().top;
  //       var elementBottom = elementTop + $(this).outerHeight();

  //       var viewportTop = $(window).scrollTop();
  //       var viewportBottom = viewportTop + $(window).height();

  //       return elementBottom > viewportTop && elementTop < viewportBottom;
  //   };

  //   jQuery(window).on('resize scroll', function () {
  //       if (jQuery('#managercomments').isInViewport()) {
  //           jQuery('#comment_sign_up_popup').show();
  //       }
  //   });
  // });


  // jQuery(document).ready(function(){
  //   jQuery('#comment_sign_up_popup_close').click(function(){
  //     jQuery('#comment_sign_up_popup').hide();
  //   });
  // });

  jQuery('#sign_up_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        email:{
          required:true,
          email:true,
        },
      },
      errorPlacement: function(error, element) {
        console.log(element.attr("id"));
        if (element.attr("id") == "sign_up_email") {
          error.appendTo("#sign_up_error");
        }
      },
      messages: {
        password: {required:"Password is required field. " },
        email: {
          required: "Email is required field.",
          email: "Your email address must be in the format of name@domain.com"
        }
      }   
  });

  jQuery('#exist_sign_up_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        email:{
          required:true,
          email:true,
        },
        password:{
          required:true,
        },
      },
      messages: {
        password: {required:"Password is required field. " },
        email: {
          required: "Email is required field.",
          email: "Your email address must be in the format of name@domain.com"
        }
      }   
  });

  jQuery('#exist_sign_up_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        email:{
          required:true,
          email:true,
        },
        password:{
          required:true,
        },
      },
      messages: {
        password: {required:"Password is required field. " },
        email: {
          required: "Email is required field.",
          email: "Your email address must be in the format of name@domain.com"
        }
      }   
  });

  jQuery('#exist_sign_up_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        email:{
          required:true,
          email:true,
        },
        password:{
          required:true,
        },
      },
      messages: {
        password: {required:"Password is required field. " },
        email: {
          required: "Email is required field.",
          email: "Your email address must be in the format of name@domain.com"
        }
      }   
  });

  jQuery('#not_exist_sign_up_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        email:{
          required:true,
          email:true,
        },
        password:{
          required:true,
          minlength:8
        },
        name:{
          required:true,
        },
        last_name:{
          required:true,
        },
      },
      messages: {
        name: {required:"First name is required field. " },
        last_name: {required:"Last name is required field. " },
        password: {required:"Password is required field. " },
        email: {
          required: "Email is required field.",
          email: "Your email address must be in the format of name@domain.com"
        }
      }   
  });

  $('#sign_up_form').submit(function(){
      if(!$('#sign_up_form').valid()){
        return false;
      }
      event.preventDefault();
      $.ajax({
          url: "{{ url('/manager-detail-signup-user-exist') }}",
          type: "post",
          data: { email: $('#sign_up_email').val() , "_token": "{{ csrf_token() }}"},
          success : function(data) {

            if(data.status == true){
              $('#sign_up_form, #sign_up_social_login').hide();
              $('#exist_sign_up_email').val($('#sign_up_email').val());
              $('#signup_popup_header').text('Log in to view feedback');
              $('#exist_sign_up_form').show();
            } else {
              $('#sign_up_form, #sign_up_social_login').hide();
              $('#not_exist_sign_up_email').val($('#sign_up_email').val());
              $('#not_exist_sign_up_form').show();
            }
          },
          error : function(data) {}
        });
    });

  $('#exist_sign_up_form').submit(function(){
      if(!$('#exist_sign_up_form').valid()){
        return false;
      }
      event.preventDefault();
      $.ajax({
          url: "{{ url('/manager-detail-user-login') }}",
          type: "post",
          data: { email: $('#exist_sign_up_email').val(), password: $('#exist_sign_up_password').val(), "_token": "{{ csrf_token() }}"},
          success : function(data) {

            if(data.status == true){
              toastr.success(data.message);
              setTimeout(function(){ location.reload(); }, 3000);
            } else {
              toastr.error(data.message);
            }
          },
          error : function(data) {}
        });
    });

  $('#not_exist_sign_up_form').submit(function(){
      if(!$('#not_exist_sign_up_form').valid()){
        return false;
      }
      $('#not_exist_sign_up_button').attr("disabled", true);
      event.preventDefault();
      $.ajax({
          url: "{{ url('/manager-detail-user-signup') }}",
          type: "post",
          data: { 
            name: $('#not_exist_sign_up_name').val(), 
            last_name: $('#not_exist_sign_up_last_name').val(), 
            email: $('#not_exist_sign_up_email').val(), 
            password: $('#not_exist_sign_up_password').val(), 
            "_token": "{{ csrf_token() }}"
          },
          success : function(data) {

            if(data.status == true){
              toastr.success(data.message);

              setTimeout(function(){ 
                $('#not_exist_sign_up_button').attr("disabled", false);
                location.reload(); 
              }, 1000);
            } else {
              if(data.message == ""){
                $('#not_exist_sign_up_form, #sign_up_social_login').hide();
                $('#matched-users').html(data.html);
                $('#matched-users-text, #matched-users').show();
              } else { 
                toastr.error(data.message);
              }
            }
          },
          error : function(data) {}
        });
    });

</script>
<style type="text/css">
  #exist_sign_up_form, #not_exist_sign_up_form, #matched-users-text, #matched-users { display: none; }
</style>