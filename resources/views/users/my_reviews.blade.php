@extends('frontend.layouts.apps')
@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12 btn-section-sticky-top text-center mb-2">
        <div class="d-block d-md-none">
            <a href="{{ url('/search/results') }}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
        </div>
      </div>
        <!-- <div class="col-md-3">
            <div class="card card-small pl-0">
            <ul class="nav vertical-nav">
                <li class="nav-item">
                  <a class="nav-link"  href="{{ url('/my-profile')}}">My Profile</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link active" href="{{ url('/my-reviews')}}">My Reviews</a>
                </li>

              </ul>
            </div>
        </div>
 -->
        <div class="col-md-12 mb-5 mt-4 mt-md-0">
            <div class="card card-small">
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="menu1" class="tab-pane active">
                 <h3 class="underline-heading font-weight-600">My Reviews
                     <a href="{{ url('/search/results') }}" class="btn btn-success with-anonymously float-right d-none d-md-inline-block">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
                 </h3>
          @if(count($data))  
              @foreach($data as $datas)  
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <small class="text-muted">{{ date_format(date_create($datas->created_at),"d,M Y ") }}</small>
                    </div>
                   <div class="col-md-8">
                       <div class="media">
                         @if($datas->user_role == 3)
                           @php 
                             $manager = $datas->manager($datas->user_id);
                            @endphp

                            <div class="media-left">
                               <div class="media-img-container small-img-container p-0">
                                 @if(!empty($manager['profile']))
                                   <a href="{{ url('manager-detail/'.$manager['id'])}}"><img src="{{ asset('images/users/'.$manager['profile'])}}" alt="profile" class="img-fluid" /></a>
                                 @else
                                   <a href="{{ url('manager-detail/'.$manager['id'])}}"><img src="{{ asset('images/default/user.png')}}" alt="profile" class="img-fluid" /></a>
                                 @endif  
                               </div>
                           </div>
                           <div class="media-body">
                              <h3>
                                @if(empty($manager['id'])) 
                                  Annonius user 
                                @else
                                  <a href="{{ url('manager-detail/'.$manager['id'])}}">{{ $manager['name']}} {{ $manager['last_name']}} </a>
                                @endif
                              </h3>
                              <h6 class="text-muted">{{ $manager['dep_name']}}</h6>
                              <h6 >
                                  <?php if($manager['job_title']){
                                  $title = $manager['job_title'];
                                  if(strlen($title) > 20){
                                    echo '<h6 class="mb-2"> <span id="half_title">'. substr($title,0, 20) .'</span> <a id="show_full_title" href="javascript:void(0)">...</a> <span id="full_title">'. $title .'</span> </h6>';
                                  } else {
                                    echo '<h6 class="mb-2">'.$title.'</h6>';
                                  }
                                } 
                                ?>
                              </h6>
                              <div class="d-block d-md-none">
                                @if($datas->working_as == 'Peer')
                                <div class="score-flex-responsive">
                                  @include('frontend.user_rating.1_thumb',['rate' => $datas->avg_review,'text' => ''])
                                  <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                                </div>
                                @else
                                <div class="score-flex-responsive">
                                  @include('frontend.user_rating.1_thumb',['rate' => $datas->avg_review,'text' => ''])
                                  <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                                </div>
                                @endif
                                   <a href="#" style="color:#276086;" class="small view_review_pop" data-id="{{$datas->id}}" data-toggle="modal" data-target="#review_details_user">Review previous evaluation</a>
                               </div>
                           </div>   
                         @endif  
                       </div>
                   </div>
                   <div class="col-md-4">
                     <div class="d-none d-md-inline-block float-right">
                    @if($datas->working_as == 'Peer')
                    <div class="score-flex-responsive">
                      @include('frontend.user_rating.1_thumb',['rate' => $datas->avg_review,'text' => ''])
                      <div class="card-small-score-sec"><img src="{{ url('/images/peer-score-small.png') }}"> Peer Score</div>
                    </div>
                    @else
                    <div class="score-flex-responsive">
                      @include('frontend.user_rating.1_thumb',['rate' => $datas->avg_review,'text' => ''])
                      <div class="card-small-score-sec"><img src="{{ url('/images/manager-score-small.png') }}"> Manager Score</div>
                    </div>
                    @endif
                       <a href="#" style="color:#276086;" class="small view_review_pop" data-id="{{$datas->id}}" data-toggle="modal" data-target="#review_details_user">Review previous evaluation</a>
                   </div>
                   </div>
               </div>
               @if(!$loop->last)
               <hr>
               @endif
            @endforeach   
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
<script type="text/javascript">
    $(document).on('click','.view_review_pop',function(){
       var id =  $(this).attr('data-id');
       var url = "{{ url('/get-user-review-model')}}/" + id;
       $('#review_model_body').load(url,function(){
        $('#review_details_user').modal({show:true});
      });
    });
</script>
@endsection