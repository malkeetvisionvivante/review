<!-- My review popup -->
@if(count($ReviewCategorys))  
  @foreach($ReviewCategorys as $ReviewCategory)
    <div class="modal-tooltip" id="manager_review_details{{$ReviewCategory->id}}">
      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1" data-id="#manager_review_details{{$ReviewCategory->id}}">×</button>
      </div>
      <div class="modal-body">
        <table class="table custom-table">
          <tr>
              <th class="border-0">{{ $ReviewCategory->name }}</th>
              <th class="border-0 d-none d-md-inline-block">&nbsp;</th>
          </tr>
           @foreach($questions as $question)
              @if($question->category_id == $ReviewCategory->id && $question->question_for == 'Manager')
              @php $questionRate =  $question->category_question_rate($ReviewCategory->name, $question->id, $data->id); @endphp
            <tr>
                <td>{{ $question->question }}</td>
                <td  class="d-none d-md-inline-block text-right" style="white-space:nowrap;">
                  <span class="text-blue mr-2 lead">{{ $questionRate }}</span>
                  @include('frontend.user_rating.5_thumb',['rate' => $questionRate])
                </td>
            </tr>
              @endif
          @endforeach
        </table>
      </div>
    </div>
  @endforeach
@endif
@if(count($ReviewCategorys))  
  @foreach($ReviewCategorys as $ReviewCategory)
    <div class="modal-tooltip" id="peer_review_details{{$ReviewCategory->id}}">
       <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1" data-id="#peer_review_details{{$ReviewCategory->id}}">×</button>
      </div>
      <div class="modal-body">
        <table class="table custom-table">
          <tr>
              <th class="border-0">{{ $ReviewCategory->name }}</th>
              <th class="border-0 d-none d-md-inline-block">&nbsp;</th>
          </tr>
           @foreach($questions as $question)
              @if($question->category_id == $ReviewCategory->id && $question->question_for == 'Peer')
              @php $questionRate =  $question->category_question_rate($ReviewCategory->name, $question->id, $data->id); @endphp
            <tr>
                <td>{{ $question->question }}</td>
                <td  class="d-none d-md-inline-block text-right" style="white-space:nowrap;">
                  <span class="text-blue mr-2 lead">{{ $questionRate }}</span>
                  @include('frontend.user_rating.5_thumb',['rate' => $questionRate])
                </td>
            </tr>
              @endif
          @endforeach
        </table>
      </div>
    </div>
  @endforeach
@endif