@extends('admin.admin_layout.admin_app')
@section('content')
  <div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1>Reviews</h1>
            </div>
            <div class="col-md-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/company/list') }}" class="text-blue">Company</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Company Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row p-0">
            <div class="col-md-9">
                <div class="media">
                    <div class="media-left">
                        <div class="media-img-container">

                            <a href="{{ url('admin/company/detail/'.$data->id)}}">
                                @if($data->logo)
                                <img src="{{ asset('images/company/'.$data->logo)}}" alt="logo" class="img-fluid" />
                                @else
                                <img src="{{ asset('images/default/user.png')}}" alt="logo" class="img-fluid" />
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="media-body">
                            <h3>{{ $data->company_name}}</h3>
                        <h6 class="text-muted">{{ $data->company_type_name}}</h6>
                        @if($data->fullAddress())
                        <h6><i class="fas fa-building"></i> {{ $data->fullAddress() }}</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-md-right creview">
                <h6 class="mb-1"><span class="thumb">
                     @if($data->company_review($data->id) < 3)
                    <i class="fas fa-thumbs-up text-red border-red"></i>
                    @elseif($data->company_review($data->id) >= 3 && $data->company_review($data->id) < 4)
                    <i class="fas fa-thumbs-up text-yellow border-yellow"></i>
                    @else
                    <i class="fas fa-thumbs-up text-green"></i>
                    @endif
                    </span>
                    {{ $data->company_review($data->id)}} Company</h6>
                <h6 class="mb-1"><span class="thumb">
                    @if($data->industry_avg($data->company_type) < 3)
                    <i class="fas fa-thumbs-up text-red border-red"></i>
                    @elseif($data->industry_avg($data->company_type) >= 3 && $data->industry_avg($data->company_type) < 4)
                    <i class="fas fa-thumbs-up text-yellow border-yellow"></i>
                    @else
                    <i class="fas fa-thumbs-up text-green"></i>

                    @endif
                    </span>
                    {{ $data->industry_avg($data->company_type) }} Industry Average</h6>
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Select Department</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control" id="dep_list">
                                  <option value="">Select Department</option>  
                                  @foreach($department_list as $department) 	
                                    <option value="{{ $department->id}}">{{ $department->name}}</option>
                                    
                                  @endforeach   
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
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
        @if(count($review_data))             
            @foreach($review_data as $datas)
                @php $customer = $datas->customer($datas->customer_id); 
                 $reviews = json_decode($datas->review_value);            
                @endphp 
             
            <div class="row m-0">
                <div class="col-md-12">
                    @if($customer)
                    <p class="mb-0 font-weight-500">Reviewed<span class="text-blue"><a href="{{url('admin/users/detail/'.$customer->id)}}" >{{ $customer->name}}</a></span></p>
                    @else
                     <p class="mb-0 font-weight-500">Reviewed</p>
                    @endif
                    <small class="text-muted-dark">{{ $datas->created_at}}<span class="ml-3"><i
                                class="fas fa-thumbs-up text-yellow mr-1"></i>{{ round($datas->avg_review,1)}}</span></small>
                    <small class="float-right p-1"><a href="#" class="text-blue" data-toggle="collapse"
                            data-target="#show{{ $datas->id}}">Show Details <i class="fas fa-angle-down"></i></a></small>

                   <div id="show{{$datas->id}}" class="collapse bg-light-blue p-3 p-md-4 mt-3">
                        <table class="table custom-table table-border-0"> 
                               
                            @foreach ($reviews as $key => $review)
                            <tr>
                                <td class="font-sizex"> {{ $datas->Question($key) }}
                                    <i class="fas fa-exclamation-circle"></i>
                                </td>
                                <td class="text-right font-sizex">

                                  @if($review < 1)
                                    <i class="fas fa-thumbs-up text-muted"></i> 
                                    <i class="fas fa-thumbs-up text-muted"></i> 
                                    <i class="fas fa-thumbs-up text-muted"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>
                                  @elseif($review >= 1 && $review < 2)
                                    <i class="fas fa-thumbs-up text-red"></i> 
                                    <i class="fas fa-thumbs-up text-muted"></i> 
                                    <i class="fas fa-thumbs-up text-muted"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>

                                  @elseif($review >= 2 &&  $review < 3)
                                  <i class="fas fa-thumbs-up text-red"></i> 
                                  <i class="fas fa-thumbs-up text-red"></i> 
                                  <i class="fas fa-thumbs-up text-muted"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>

                                  @elseif($review >= 3  && $review < 4)
                                    <i class="fas fa-thumbs-up text-yellow"></i> 
                                    <i class="fas fa-thumbs-up text-yellow"></i>
                                    <i class="fas fa-thumbs-up text-yellow"></i> 
                                    <i class="fas fa-thumbs-up text-muted"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>

                                  @elseif($review >= 4 && $review < 5)
                                    <i class="fas fa-thumbs-up text-green"></i> 
                                    <i class="fas fa-thumbs-up text-green"></i>
                                    <i class="fas fa-thumbs-up text-green"></i> 
                                    <i class="fas fa-thumbs-up text-green"></i>
                                    <i class="fas fa-thumbs-up text-muted"></i>

                                  @elseif($review <= 5)
                                    <i class="fas fa-thumbs-up text-green"></i> 
                                    <i class="fas fa-thumbs-up text-green"></i>
                                    <i class="fas fa-thumbs-up text-green"></i> 
                                    <i class="fas fa-thumbs-up text-green"></i>
                                    <i class="fas fa-thumbs-up text-green"></i>
                                  @endif
                                </td>
                            </tr>
                            
                    @endforeach    
                </table>
            </div>         
                   
                </div>
            </div>
            <hr>
        @endforeach    
      @else
       
      @endif 

        
        </div>    
        
        </div>
    </div>
</div>

@endsection
@section('scripts')
 <script type="text/javascript">
     jQuery('#dep_list').change(function(){
        var department_id = jQuery(this).val();
        if(department_id){
            jQuery("#select_manager").prop('disabled', true);
            jQuery.ajax({
                type:"get",
                url:" {{ url('/get/company/dep/manager') }}/"+department_id+"/{{$data->id}}", 
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

      }
   })  
 </script>
@endsection