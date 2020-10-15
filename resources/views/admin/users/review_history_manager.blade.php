@if(count($data)) 
                @foreach($data as $datas)
                  @php $customer = $datas->customer1($type == 'user_id' ? $datas->customer_id : $datas->user_id); 
                     $reviews = json_decode($datas->review_value);            
                    @endphp   
            <div id="_panel_{{$datas->id}}" class="row p-0">
                <div class="col-md-12">
                @if ($type == 'user_id')
                    <p class="mb-0 font-weight-500"><span class="text-blue">{{ $customer->name." ".$customer->last_name }}</span> reviewed
                    <span class="text-blue">{{ $data1->name." ".$data1->last_name }}</span></p>
                    @else 
                    <p class="mb-0 font-weight-500"><span class="text-blue">{{ $data1->name." ".$data1->last_name }}</span> reviewed
                    <span class="text-blue">{{ $customer->name." ".$customer->last_name }}</span></p>
                    @endif
                    <small class="text-muted-dark">{{ $datas->created_at}}<span class="ml-3"><i
                                class="fas fa-thumbs-up text-green"></i> {{ round($datas->avg_review,1) }}</span></small>
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
                            <tr>
                            <td><Strong>REVIEW:</Strong></td>
                              <td class="text-right">
                                <a title="{{$datas->hidden_review == 1 ? 'Show Review' : 'Hide Review' }}" href="javascript:void(0)" class="hide-review" data-id="{{$datas->id}}">
                                    <i class="hide-review-icon fas {{$datas->hidden_review == 1 ? 'fa-eye-slash' : 'fa-eye'}}"></i>
                                </a>
                                <a title="Delete Review" href="javascript:void(0)" role="review" class="key-trash" data-id="{{$datas->id}}">
                                    <i class="fas fa-trash"></i>
                                </a>
                              </td>
                            </tr>
                            @foreach ($reviews as $key => $review)
                            <tr class="_review_{{$datas->id}}_">
                                <td class="font-size"> {{ $datas->Question($key) }}
                                    <i class="fas fa-exclamation-circle"></i>
                                </td>
                                <td class="text-right font-size">
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
                    @if($datas->comment != null && $datas->comment != '') 
                            <tr>
                              <td class="pt-4" colspan="3"><Strong>COMMENT:</Strong></td>
                            </tr>
                            <tr id="_comment_{{$datas->id}}_">
                              <td colspan="2">{{$datas->comment}}</td>
                              <td>
                                <a id="_cmnt{{$datas->id}}" title="{{$datas->hidden_comment == 1 ? 'Show Comment' : 'Hide Comment' }}" href="javascript:void(0)" class="hide-comment {{$datas->hidden_review==1?'_reviewHidden':''}}" data-id="{{$datas->id}}">
                                    <i class="hide-comment-icon fas {{$datas->hidden_comment == 1 ? 'fa-eye-slash' : 'fa-eye'}}"></i>
                                </a>
                              </td>
                              <td>
                                <a title="Delete Comment" href="javascript:void(0)" role="comment" class="key-trash" data-id="{{$datas->id}}">
                                    <i class="fas fa-trash"></i>
                                </a>
                              </td>
                            </tr>
                    @endif
                    </table>
                    </div>         
                </div>
            </div>
            <hr id="_hr_{{$datas->id}}">
        @endforeach  
        {{ $data->links() }}  
      @else
        <p class="text-muted text-center m-4" style="">No Reviews found!!!</p>
      @endif