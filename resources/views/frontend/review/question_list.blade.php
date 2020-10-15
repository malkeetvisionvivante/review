@foreach($ReviewCategory as $category)
@if($category->question_count1($category->id, $for) > 0)
  <fieldset class="questions-set">
      <div class="row p-0">
          <div class="col-md-12">
            <h4 class="mb-3 font-weight-700">Review <span class="manager-name">{{ $managerName }}</span> across the following qualities</h4>
          </div>
          <div class="col-md-12 {{ $category->id }}_class">
              <div class="table-responsive mt-4 mt-md-0">
              <table class="table custom-table mb-0">
                  <tr>
                      <th>Qualities<span class="font-weight-normal">: {{ $category->name }}</span></th>
                      <th class="text-right">Rate the quality</th>
                  </tr>
              </table>
              </div>
              <table class="table custom-table table-striped">
                 @foreach($questions as $question)
                  @if($question->category_id == $category->id)
                    <tr>
                        <td>{{ $question->question }}</td>
                        <td  class="text-right" style="white-space:nowrap;">
                          <input type="hidden" class="question_{{$question->id}}" name="question[{{ $category->id }}][{{$question->id}}]">
                          <i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_1"></i> 
                          <i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_2"></i> 
                          <i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_3"></i> 
                          <i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_4"></i> 
                          <i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_5"></i>
                        </td>
                    </tr>
                  @endif
                @endforeach
              </table>
               <div class="col-md-12 mt-3 error-class question-error {{$category->name}}-error"> Please answer all of the questions.</div>
               <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
              <a href="javascript:void(0)" data="{{ $category->id }}" class="next float-right h6 text-blue">Next <i class="fas fa-arrow-right"></i></a>
          </div>
      </div>
  </fieldset>
  @endif
@endforeach