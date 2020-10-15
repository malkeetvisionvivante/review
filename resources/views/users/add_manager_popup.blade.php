<!-- add manager -->
@if(Auth::user()->isAbleToAdd())
<div class="modal fade" id="request_new_manager">
  <div class="modal-dialog modal-dialog-centered" id="modal_lg">

    <div class="modal-content" id="add_colleague_form">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>New colleague addition</h4>
        <form method="post" id="add_manager_form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>First name</label>
                <input type="text" placeholder="First name" class="form-control" name="first_name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Last name</label>
                <input type="text" placeholder="Last name" class="form-control" name="last_name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Company</label>
                @if(Auth::check())
                <input type="text" placeholder="Company" list="company_list" class="form-control" name="company_name" id="search_company_list" autocomplete="off" value="{{ Auth::user()->companyName(Auth::user()->company_id)}}">
                @else
                <input type="text" placeholder="Compnay name" list="company_list" class="form-control" name="company_name" id="search_company_list" autocomplete="off">
                @endif
                <datalist id="company_list"></datalist>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Department</label>
                <select class="form-control create_manger_department_hidden" name="department_id">
                  <option value="">Select</option>
                  @if(Auth::check())
                    @if(count($departments))  
                      @foreach($departments as $department)
                        @if( Auth::user()->department_id == $department->id)
                        <option selected value="{{ $department->id }}">{{ $department->name}}</option>
                        @else
                        <option value="{{ $department->id }}">{{ $department->name}}</option>
                        @endif
                      @endforeach
                    @endif 
                  @else
                    @if(count($departments))  
                      @foreach($departments as $department)
                        <option value="{{ $department->id}}">{{ $department->name}}</option>
                      @endforeach
                    @endif 
                  @endif 
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Job title</label>
                <input list="title_list" placeholder="Job title" class="form-control" name="job_title" id="search_title" autocomplete="off">
                <datalist id="title_list"></datalist>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>LinkedIn profile URL</label>
                <input type="text" placeholder="Copy+paste their linkedin profile URL here" class="form-control" value="" name="linkedin_url">
              </div>
            </div>
            <div class="col-md-10">
              <button type="button" class="btn round-shape" id="only_submit">Submit</button>
              <button type="button" class="btn btn-success round-shape" id="submit_and_add_another">Submit and add another!</button>
            </div>
          </div>
        </form>
      </div>
    </div>
     <div class="modal-content" id="add_colleague_match_data">
     </div>

  </div>
</div>
@else
<div class="modal fade" id="request_new_manager">
  <div class="modal-dialog modal-dialog-centered" id="modal_lg">

    <div class="modal-content" id="add_colleague_form">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>New addition rejected.</h4>
        <p>Hey! It looks like you’ve already added 2 new profiles with very similar details, so our system is preventing this action. Please reach out to <b>support@blossom.team</b> if you think this is wrong. </p>
      </div>
    </div>
     <div class="modal-content" id="add_colleague_match_data">
     </div>

  </div>
</div>
@endif
<script type="text/javascript">
    $('#search_company_list').keyup(function(){
      $.ajax({
          url: "{{ url('/load-company-list') }}",
          type: "post",
          data: { data: jQuery(this).val() , "_token": "{{ csrf_token() }}"},
          success : function(data) { 
              $('#company_list option').remove();
              $('#company_list').prepend(data); 
          },
          error : function(data) {}
        });
    });

    $('#company_list option').click(function(){
      $(this).next().focus();
      $('#company_list option').remove();
    });

    jQuery('#add_manager_form').validate({
    ignore: [],
    errorClass:"error-message",
    validClass:"green",
    rules:{
        first_name:{
            required:true,
        },
        last_name:{
            required:true,
        },
        company_name:{
            required:true,
        },
        job_title:{
            required:true,
        },
        linkedin_url:{
             url: true,
        },
        department_id:{
            required:true,
        },
      },
       messages: {
        first_name: {required:"First name is required field. " },
        last_name: {required:"Last name is required field. " },
        phone: {required:"Phone number is required field. " },
        company_name: {required:"Company name is required field. " },
        job_title: {required:"Job title is required field. " },
        department_id: {required:"Department is required field. " },
        email: {
          required: "Email is required field.",
          email: "Your email address must be in the format of name@domain.com"
        }
      },
    });

    $('#only_submit').click(function(){
      if(!$('#add_manager_form').valid()){
        return false;
      }
      event.preventDefault();
      $.ajax({
          url: "{{ url('/add-manager-from-search-page') }}",
          type: "post",
          data: { data: $('#add_manager_form').serialize() , "_token": "{{ csrf_token() }}","add_another" :false },
          success : function(data) { 
            var data  = JSON.parse(data);
            if(data.status == true && data.match == true){
              $('#add_colleague_form').hide();
              $("#modal_lg").addClass("modal-lg");
              $('#add_colleague_match_data').html(data.html).show();
            } else {
              $('.close').trigger('click');
              toastr.success(data.message);
              window.location.href = "{{ url('/manager-detail/') }}"+"/"+data.user_id;
            }
          }
        });
    });

    $('#submit_and_add_another').click(function(){
      if(!$('#add_manager_form').valid()){
        return false;
      }
      event.preventDefault();
      $.ajax({
          url: "{{ url('/add-manager-from-search-page') }}",
          type: "post",
          data: { data: $('#add_manager_form').serialize() , "_token": "{{ csrf_token() }}","add_another" :true },
          success : function(data) { 
            var data  = JSON.parse(data);
            if(data.status == true && data.match == true){
              $('#add_colleague_form').hide();
              $("#modal_lg").addClass("modal-lg");
              $('#add_colleague_match_data').html(data.html).show();
            } else {
              $('#add_manager_form input, #add_manager_form select').val('');
              toastr.success(data.message);
            }
          }
        });
    });

    $('#add_manager_form').submit(function(){
      
    });

</script>
<style type="text/css">#add_colleague_match_data{ display: none; } </style>