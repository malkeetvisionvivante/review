
@extends('admin.admin_layout.admin_app')
@section('content')

        <div class="inner-container">
        <div class="card my-3 border-bottom">
            <div class="row p-0 justify-content-between">
                <div class="col-md">
                    <h1>Reviews</h1>
                </div>
                <div class="col-md">
                  <form name="search_dep" action="{{ url('company/review/list')}}" method="get">
                     @csrf
                    <div class="input-group mb-1">
                        <input type="text" name="name" value="{{ $name }}" class="form-control border-right-0"
                            placeholder="Search manager">
                        <div class="input-group-prepend mr-0">
                            <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>
                        </div>
                    </form>  
                    </div>
                </div>
            </div>
        </div>
          @if(count($data))  
              @foreach($data as $datas)  
                <div class="row m-0" style="background: #ffffff;">
                    <div class="col-md-12 mb-2">
                        <small class="text-muted">{{ $datas->created_at->diffForHumans()}}</small>
                    </div>
                   <div class="col-md-7">
                       <div class="media">
                         @if($datas->user_role == 4)
                           @php 
                             $manager = $datas->manager($datas->user_id);
                            @endphp
                            <div class="media-left">
                               <div class="media-img-container small-img-container">
                                   <a href="#"><img src="{{ asset('images/manager/'.$manager->profile)}}" alt="profile" class="img-fluid" /></a>
                               </div>
                           </div>
                           <div class="media-body">
                               <h3>{{ $manager->first_name}} {{ $manager->last_name}}</h3>
                               <h6 class="text-muted">{{ $manager->dep_name}}</h6>
                               <h6>Review by <a href="#" >{{ $datas->customer_name($datas->customer_id)}}</a></h6>
                           </div>   
                         
                         @endif  
                       </div>
                   </div>
                   <div class="col-md-5 text-right">
                       <p class="m-0"><span class="thumb"><i class="fas fa-thumbs-up text-green"></i></span> {{ $datas->avg_review}}</p>
                       <a href="#" style="color:#276086;" class="small view_review_pop" data-id="{{$datas->id}}" data-toggle="modal" data-target="#review_details_user">Review previous evaluation</a>
                   </div>
               </div>
               <hr>
            @endforeach   
            {{ $data->appends(['name'=> $name])->links() }}
          @else
            <p style="margin-left: 5px;">No Reviews Found!!</p>
          @endif     
            </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="review_details_user">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body pt-1" id="review_model_body">
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).on('click','.view_review_pop',function(){
       var id =  $(this).attr('data-id');
       var url = "{{ url('/company/get-user-review-model')}}/" + id;
       $('#review_model_body').load(url,function(){
        $('#review_details_user').modal({show:true});
      });
    });
</script>

@endsection