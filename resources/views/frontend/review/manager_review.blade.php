@extends('frontend.layouts.apps')
@section('content')
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<style type="text/css">
	.rating input {
  border: 0;
  width: 1px;
  height: 1px;
  overflow: hidden;
  position: absolute !important;
  clip: rect(1px 1px 1px 1px);
  clip: rect(1px, 1px, 1px, 1px);
  opacity: 0;
}

.rating label {
  position: relative;
  float: right;
  color: #C8C8C8;
}

.rating label:before {
  margin: 5px;
  content: "\f005";
  font-family: FontAwesome;
  display: inline-block;
  font-size: 1.5em;
  color: #ccc;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

.rating input:checked ~ label:before {
  color: #FFC107;
}

.rating label:hover ~ label:before {
  color: #ffdb70;
}

 .rating label:hover:before {
  color: #FFC107;
}
.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
</style>
<div class="container-fluid">
    <div class="card small mt-2">
        <div class="row p-0">
            <div class="col-md-9">
                <div class="media align-items-center">
                    <div class="media-left">
                        <div class="media-img-container">
                            <img src="{{ asset('images/manager/'.$data->profile)}}" alt="profile" class="img-fluid" />
                        </div>
                    </div>
                    <div class="media-body">
                        <h3>{{ $data->first_name}} {{ $data->last_name}}</h3>
                        <h6 class="text-muted"></h6>
                    </div>
                </div>
  
            </div>
            <div class="col-md-3 text-center text-md-right score">
            <p class="mb-1"><span class="thumb"><i class="fas fa-thumbs-up"></i></span> </p>
            </div>
        </div>
    </div>

    <div class="card small mt-2">
        <div class="row p-0">
            <div class="col-md-12">
                <h3>Submit your review</h3>
                <span class="text-muted">All reviews are anonymized</span>

              
            </div>
            </div>
        </div>
    <div class="card small mt-2 @if($check == 1) disabledbutton @endif">
        <div class="row p-0">
            <div class="col-md-9">
                <h4 class="mb-3 font-weight-700">Review the manager across the following qualities</h4>
            </div>
           
            <div class="col-md-3">
                <div class="rating-progress progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                <table class="table custom-table">
                    <tr>
                        <th>Qualities</th>
                        <th class="text-right">Rate the quality</th>
                    </tr>
                </table>
                </div>
                <div id="msform">
                  @if(count($questions))
                    <form name="questions" action="{{ url('/submit_review_manager/'.$data->id)}}" method="post">
                     @csrf   
                    @php 
                    $total_question = count($questions) - 1;
                    $question_ids = $questions->pluck('id')->toArray();


                    @endphp
                   @foreach($questions as $key => $value) 
                        <fieldset>
                            <table class="table custom-table">
                            <tr>
                                <td colspan="2" class="font-weight-600 border-0 py-2"> {{ $value->question}}</td>
                            </tr>
                            <tr>
                                <td class="border-0 py-2"> {{ $value->description}}  <i class="fas fa-exclamation-circle"></i></td>
                                <td class="border-0 py-2 text-right rating" style="white-space:nowrap;">
                                      <input type="checkbox" name="rating{{$value->id}}" id="star5{{$key}}{{ $value->id }}" value="5" />
                                      <label for="star5{{$key}}{{ $value->id }}"></label>
                                      <input type="checkbox" name="rating{{$value->id}}" id="star4{{$key}}{{ $value->id }}" value="4" />
                                      <label for="star4{{$key}}{{ $value->id }}"></label>
                                      <input type="checkbox" name="rating{{$value->id}}" id="star3{{$key}}{{ $value->id }}" value="3" />
                                      <label for="star3{{$key}}{{ $value->id }}"></label>
                                      <input type="checkbox" name="rating{{$value->id}}" id="star2{{$key}}{{ $value->id }}" value="2" />
                                      <label for="star2{{$key}}{{ $value->id }}"></label>
                                     <input type="checkbox" name="rating{{$value->id}}" id="star1{{$key}}{{ $value->id }}" value="1" />
                  <label for="star1{{$key}}{{ $value->id }}"></label>
                                </td>
                            </tr>
                            </table>
                           @if($key > 0) 
                             <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
                           @endif
                           <input type="hidden" name="question_ids[]" value="{{ $value->id }}">
                           @if($key < $total_question)  
                            <a href="javascript:void(0)" class="next float-right h6 text-blue nxt-button">Next <i class="fas fa-arrow-right"></i></a>
                           @else
                              <button type="submit" class="btn btn-success round-shape float-right sub-review-btn">Submit</button> 
                           @endif
                        </fieldset>

                   @endforeach   
                      <input type="hidden" id="manager-id" name="manager_id" value="{{ $data->id}}">    
                     </form> 
                  @else
                    <p>No Review Questions Found!!</p>
                  @endif     
                </div>
            </div>
        </div>
    </div>
 </div>




@endsection