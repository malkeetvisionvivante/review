<!-- add manager -->
@if(Auth::user()->isAbleToAdd())
<div class="modal fade" id="request_new_manager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>New colleague addition</h4>
        <form method="post" id="add_manager_form">
          <input type="hidden" name="company_id" value="{{ $company->id }}"> 
        <!-- <input type="hidden" name="department_id" class="create_manger_department_hidden"> -->
          <div class="row">
             <!-- <div class="col-md-12">
              <div class="form-group">
                <label>Manager’s email</label>
                <input type="text" placeholder="Manager’s email" class="form-control" name="email">
              </div>
            </div> -->
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
                <input type="text" placeholder="Company" id="custom_company_field_for_popup" class="form-control" value="{{ $company->company_name }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Department</label>
                <input type="hidden" name="department_id" class="form-control create_manger_department_hidden" value="">
                <select class="form-control create_manger_department_hidden" disabled>
                  <option value="">Select</option>
                   @if(count($departments))  
                      @foreach($departments as $department)
                        <option value="{{ $department->id}}">{{ $department->name}}</option>
                      @endforeach
                    @endif 
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Job title</label>
                <!-- <input type="text" placeholder="Job Title" class="form-control" name="job_title"> -->
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
            <!-- <div class="col-md-6">
              <div class="form-group">
                <label>Manager’s phone number</label>
                <input type="text" placeholder="Manager’s phone number" class="form-control" name="phone">
              </div>
            </div> -->
          </div>
          <button type="submit" class="btn btn-success round-shape">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@else
<div class="modal fade" id="request_new_manager">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>New addition rejected.</h4>
        <p>Hey! It looks like you’ve already added 2 new profiles with very similar details, so our system is preventing this action. Please reach out to <b>support@blossom.team</b> if you think this is wrong. </p>
      </div>
    </div>
  </div>
</div>
@endif