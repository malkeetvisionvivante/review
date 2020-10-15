    @if(isset($manager))  
         <div class="row m-0">
            <div class="col-md-12 mt-3">
                <div class="media align-items-center">
                    <div class="media-left">
                        <div class="media-img-container p-0 rounded">
                          @if(!empty($datas->profile))
                            <a href="{{ url('/admin/users/detail/'.$manager->id) }}"><img src="{{ asset('images/users/'.$manager->profile)}}" alt="Manager-profile" class="img-fluid" /></a>
                          @else
                          <a href="{{ url('/admin/users/detail/'.$manager->id) }}"><img src="{{ asset('images/default/user.png')}}" alt="Manager-profile" class="img-fluid" /></a>
                          @endif
                        </div>
                    </div>
                    <div class="media-body">
                        <h5><a href="{{ url('/admin/users/detail/'.$manager->id) }}">{{$manager->name}} {{ $manager->last_name}}</a></h5>
                    </div>
                </div>
            </div>
        </div><hr>   
      @if(count($data)) 
            
        @foreach($data as $datas)
                  @php $customer = $datas->customer($datas->customer_id); 
                     $reviews = json_decode($datas->review_value);            
                    @endphp 
             
            <div class="row m-0">
                <div class="col-md-12">
                    
                    <p class="mb-0 font-weight-500">Reviewed <span class="text-blue"><a href="{{url('admin/users/detail/'.$customer->id)}}" >{{ $customer->name}} {{ $customer->last_name}}</a></span></p>
                    <small class="text-muted-dark">{{ $datas->created_at}}<span class="ml-3"><i
                                class="fas fa-thumbs-up @if($datas->avg_review < 3) text-red @elseif($datas->avg_review < 4 && $datas->avg_review >= 3) text-yellow @else text-green @endif"></i> {{ round($datas->avg_review,1)}}</span></small>
                    <small class="float-right pt-1">
                      <span class="text-blue show-detail show{{ $datas->id}}" data="{{ $datas->id}}">Show Details 
                          <i class="fas fa-angle-down"></i>
                      </span>
                      <span class="text-blue hide-detail hide{{ $datas->id}}" data="{{ $datas->id}}">Hide Details 
                          <i class="fas fa-angle-up"></i>
                      </span>

                    </small>

                    <div class="collapse bg-light-blue p-3 p-md-4 mt-3 showreview{{$datas->id}}">
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

                                  @else
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
        <p class="text-muted" style="margin-left: 2%;">No Reviews found!!!</p>
      @endif 
  @else
      <p>Something went Wrong!!</p>
    @endif 
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.show-detail').click(function(){
            var id = jQuery(this).attr('data');
            jQuery('.showreview'+id).show();
            jQuery('.hide'+id).show();
            jQuery('.show'+id).hide();
        });
        jQuery('.hide-detail').click(function(){
            var id = jQuery(this).attr('data');
            jQuery('.showreview'+id).hide();
            jQuery('.hide'+id).hide();
            jQuery('.show'+id).show();
        });
    });
</script>         