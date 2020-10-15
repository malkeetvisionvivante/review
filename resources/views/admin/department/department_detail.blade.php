@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1>Department Detail</h1>
            </div>
            <div class="col-md-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/department/list') }}" class="text-blue">Departments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Department Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row p-0">
            <div class="col-md-9">
                <div class="media">
                    <div class="media-body">
                        <h3> {{ $data->name }} </h3>
                    </div>
                </div>
            </div>
           <div class="col-md-3 text-right">
                <a  href="{{ url('admin/delete/dept/'.$data->id)}}" onclick="return confirm('Are You Sure delete Department Permanently!')"  class="text-blue"><i class="fas fa-trash"></i></a>
            </div>
            <div class="col-md-12">
                <hr>
                <h3> Description  </h3>{{ $data->description }}
            </div>
        </div>
        <hr>
        <div class="row p-0">
            <div class="col-md-12 mb-3">
                <h3>Review History</h3>
            </div>
        </div>
        <div class="border">
                <div class="row p-0">
                <div class="col-md-12">
                    <form method="post" class="bg-light-blue p-3 border-bottom after-arrow">
                        <!-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Select Department</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control" id="dep_list">
                                      <option value="">Select Department</option>    
                                        <option value="{{ $data->id}}">{{ $data->name}}</option>  
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Select Manager</label>
                                </div>
                                <div class="col-md-9">
                                    <select id="select_manager" class="form-control">
                                       <option value="">Select Manager</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="review_data">     
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
     jQuery('#dep_list').change(function(){
        var department_id = jQuery(this).val();
        if(department_id){
            jQuery("#select_manager").prop('disabled', true);
            jQuery.ajax({
                type:"get",
                url:" {{ url('/get/dep/manager') }}/"+department_id, 
                success:function(data) {    
                    console.log(data);   
                    jQuery("#select_manager").html(data);
                     jQuery("#select_manager").val('');  
                     jQuery("#select_manager").prop('disabled', false);  
                }
            });
        }
    });
   $('#select_manager').change(function(){
      var manager_id = $(this).val();
      if(manager_id)
      {
         $.ajax({
                type:"get",
                url:" {{ url('/company/manager/review') }}/"+manager_id, 
                success:function(data) {    
                    $('#review_data').empty();
                    $('#review_data').html(data);
                }
            });

      } else {
        $('#review_data').empty();
      }
   });
   jQuery(document).ready(function(){
     jQuery.ajax({
                type:"get",
                url:" {{ url('/get/dep/manager') }}/{{$data->id}}", 
                success:function(data) {    
                    console.log(data);   
                    jQuery("#select_manager").html(data);
                     jQuery("#select_manager").val('');  
                     jQuery("#select_manager").prop('disabled', false);  
                }
            });
   });
 </script>

@endsection