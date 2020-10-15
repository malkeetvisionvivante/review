@extends('admin.admin_layout.admin_app')
@section('content')

<div class="inner-container">
  @if(Session::has('flash_message_success'))
    <div class="alert alert-success">
        {{Session::get('flash_message_success')}}
    </div>
@endif
  <div class="card my-3 border-bottom">
    <div class="row p-0 justify-content-between">
        <div class="col-md">
            <h1>Companies</h1>
        </div>
        <div class="col-md">
           <form name="seach_company" action="{{ url('admin/company/list')}}" method="get">
            <div class="input-group mb-1">
              
                 @csrf  
                <input type="text" name="company_name" value="{{ $name }}" class="form-control border-right-0"
                    placeholder="Search Company">
                <div class="input-group-prepend mr-0">
                    <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>
                </div>
                  
                <a href="{{ url('admin/add/company')}}" class="btn btn-success round-shape ml-2">Add Company</a>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="card mt-2">
  @if(count($data))  
   @foreach($data as $datas)
    
    <div class="row p-0">
        <div class="col-md-8">
            <div class="media">
                <div class="media-left">
                  @if(!empty($datas->logo))  
                    <div class="media-img-container">
                       <a href="{{ url('admin/company/detail/'.$datas->id)}}"><img src="{{ asset('images/company/'.$datas->logo)}}" alt="apple" class="img-fluid" /></a>
                    </div>
                  @else
                    <div class="media-img-container">
                       <a href="{{ url('admin/company/detail/'.$datas->id)}}"><img src="{{ asset('images/default/user.png')}}" alt="apple" class="img-fluid" /></a>
                    </div>
                  @endif  
                </div>
                <div class="media-body">
                    <a href="{{ url('admin/company/detail/'.$datas->id)}}"><h3>{{ $datas->company_name }}</h3></a>
                   <h6 class="text-muted">{{ $datas->comp_type($datas->company_type) }}</h6>
                   @if($datas->fullAddress())
                    <h6 class="text-muted line-height-20"><i class="fas fa-building"></i> {{ $datas->fullAddress() }}</h6>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-right">
            <div class="mb-2">
            <div class="custom-control custom-switch custom-control-inline">
                <input type="checkbox" class="custom-control-input change_status" data-id="{{ $datas->id}}" id="status{{$datas->id}}" @if($datas->status == 0) checked @endif>
                <label class="custom-control-label"for="status{{$datas->id}}" >Visible</label>
            </div>
            
                <a href="{{url('admin/edit/company/'.$datas->id)}}"  class="h6 text-blue"><i class="fas fa-pencil-alt"></i> Edit</a>
                <a  href="{{ url('admin/delete/comp/'.$datas->id)}}" onclick="return confirm('Are You Sure delete Company permanently!')"  class="h6 text-blue ml-3"><i class="fas fa-trash"></i> Delete</a>
            </div>
               
            <h6 class="mb-1">
                <span class="thumb">
                    @if($datas->company_review($datas->id) < 3)
                    <i class="fas fa-thumbs-up text-red border-red"></i>
                    @elseif($datas->company_review($datas->id) >= 3 && $datas->company_review($datas->id) < 4)
                    <i class="fas fa-thumbs-up text-yellow border-yellow"></i>
                    @else
                    <i class="fas fa-thumbs-up text-green"></i>
                    @endif
                </span>
                    {{ $datas->company_review($datas->id)}} Company
            </h6>
            <h6 class="mb-1">
                <span class="thumb">
                    @if($datas->industry_avg($datas->company_type) < 3)
                    <i class="fas fa-thumbs-up text-red border-red"></i>
                    @elseif($datas->industry_avg($datas->company_type) >= 3 && $datas->industry_avg($datas->company_type) < 4)
                    <i class="fas fa-thumbs-up text-yellow border-yellow"></i>
                    @else
                    <i class="fas fa-thumbs-up text-green"></i>
                    @endif
                </span>
                    {{ $datas->industry_avg($datas->company_type) }} Industry Average
            </h6>
        </div>
    </div>
    <hr>
   @endforeach  
     <div class="row mt-5">
        <div class="col-">
            {{ $data->links()}}
        </div>
        <div class="col- ml-4">
            <span class="text-muted" style="font-size: 14px;">
                Showing {{count($data)}} of {{$countData}} Results
            </span>
        </div>
    </div>
</div>
 @else
   <p>No results found.</p>
 @endif   
   



</div>
</div>

@endsection
@section('scripts')
 <script type="text/javascript">
     $(document).on('click','.change_status',function(){
        if(confirm('Are You sure to change status'))
        {
           var id = $(this).attr('data-id');
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax(
            {
                // url: "{{url('search_filter/admin/quiz')}}",
                url: "{{ url('change_status/comp')}}/"+id,
                type: "post",
                data: {'id':id},
                success : function(data) { 
                   location.reload();
                },
                error : function(data) {

                }
            });
        }
        return false;
        
});
 </script>

@endsection