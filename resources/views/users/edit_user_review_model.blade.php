<div class="row">
  <div class="col-md-12">
    <h3>Edit Review</h3>
  </div>
</div>
@php  $reviews = (array)json_decode($review_data->review_value);   @endphp
<?php $firstStep = 0; ?>
<div id="msform" class="mt-3">
  <form action="{{ url('/edit/review/'.$review_data->id) }}" method="post">
    @csrf
  <div class="row mb-3">
    <div class="col-md-12">
        <div class="rating-progress progress">
            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
  </div>
  @foreach($ReviewCategory as $category)
  @if($category->question_count1($category->id,'Manager') > 0)
  <?php $firstStep++; ?>
    <fieldset class="questions-set">
        <div class="row p-0">
            <div class="col-md-12">
                @if($manager)
                <h4 class="mb-3 font-weight-700">Review {{ $manager->name}} {{ $manager->last_name}} across the following qualities</h4>
                @else
                <h4 class="mb-3 font-weight-700">Review <span class="manager-name"></span> across the following qualities</h4>
                @endif
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
                            <input type="hidden" class="question_{{$question->id}}" name="question[{{ $category->id }}][{{$question->id}}]" value="{{ $reviews[$question->id] }}">
                            @include('frontend.user_rating.5_review_thumb',['question' => $question, 'rate' => $reviews[$question->id]])
                          </td>
                      </tr>
                    @endif
                  @endforeach
                </table>
                 <div class="col-md-12 mt-3 error-class question-error {{$category->name}}-error"> Please answer all of the questions.</div> @if($firstStep != 1)                       
                 <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
                 @endif
                <a href="javascript:void(0)" data="{{ $category->id }}" class="next float-right h6 text-blue">Next <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </fieldset>
    @endif
  @endforeach
  <fieldset>
  <div class="row p-0">
      <div class="col-md-12">
          @if($manager)
            <h6 class="mt-3 mb-1">
              What advice would you give to {{ $manager->name}} {{ $manager->last_name}} to further improve?
            </h6>
          @else
            <h6 class="mt-3 mb-1">
              What advice would you give to <span class="manager-name"></span> to further improve?
            </h6>
          @endif
          <div class="mt-3">
              <textarea name="comment" id="comment" rows="3" class="form-control">{{ $review_data->comment }}</textarea>
          </div>
      </div>
    <div class="col-md-12">  
      <div class="mb-3 mt-1 text-muted" style="display: block;"> Character limit #<span class="comment-length">0</span>/750.</div>
      <div class="error-class mb-3  error-class comment-error mt-1"> Please enter a comment.</div>
      <div class="row mt-3">
          <div class="col-6">
              <a href="javascript:void(0)" class="previous float-left h6 text-blue"><i class="fas fa-arrow-left"></i> Back</a>
          </div>
          <div class="col-6 text-right">
            <button type="submit" class="submit btn btn-success round-shape" data="{{ $category->id }}">Submit<br><small>(anonymous)</small></button> 
          </div>
      </div>
  </div>
  </div>
  </fieldset>
</div>
<script type="text/javascript">
  $(document).on('click','.question',function(){
      var rate = $(this).attr('data');
      var question_id = $(this).attr('data-que');
      $('.question-error').hide();
      $('.question_'+question_id).val(rate);
      for (var i = 1; i <= 5; i++) {
        $('.question_'+question_id+'_'+i).addClass('text-muted');
        $('.question_'+question_id+'_'+i).removeClass('text-red border-red');
        $('.question_'+question_id+'_'+i).removeClass('text-yellow border-yellow');
        $('.question_'+question_id+'_'+i).removeClass('text-green border-green');
      }
      if(rate <3){
        for (var i = 1; i <= rate; i++) {
          $('.question_'+question_id+'_'+i).removeClass('text-muted');
          $('.question_'+question_id+'_'+i).addClass('text-red border-red');
        }
      } else if(rate >=3 && rate < 4){
        for (var i = 1; i <= rate; i++) {
          $('.question_'+question_id+'_'+i).removeClass('text-muted');
          $('.question_'+question_id+'_'+i).addClass('text-yellow border-yellow');
        }
      } else {
        for (var i = 1; i <= rate; i++) {
          $('.question_'+question_id+'_'+i).removeClass('text-muted');
          $('.question_'+question_id+'_'+i).addClass('text-green border-green');
        }
      }
    });
    $('button.submit').click(function(){
      if($('#comment').val() == ''){
        $('.comment-error').text('Please enter a comment.').show();
        return false;
      }
      var str = $('#comment').val();
      if (!str.replace(/\s/g, '').length) {
        $('.comment-error').text('Only whitespace is not accepted.').show();
        return false;
      }
      if($('#comment').val().length > 750){
        $('.comment-error').text('Comment must be less then 750 Characters.').show();
        return false;
      }
    });
</script>

<script>
  var current_fs, next_fs, previous_fs; 
  var opacity;
  var current = 1;
  var steps = $("fieldset").length;
  setProgressBar(current);
  $(document).on('click', ".next",function(){

    if($(this).hasClass('department_next') && ($('.department_hidden').val() == '')){
      $('.department-error').show();
      return false;
    }

    if($(this).hasClass('manager_next') && (($('.manager_hidden').val() == "") || ($('.manager_hidden').val() == null))) {
      $('.manager-error').show();
      return false;
    }
    if($(this).attr('data')){
      var class1 = $(this).attr('data');
      var error = 0;
      $('.'+class1+'_class input').each(function(){
        if($(this).val() == ''){
          error = 1;
        }
      });
      if(error == 1){
        $('.question-error').show();
        return false;
      }
    }

    current_fs = $(this).parents('fieldset:eq(0)');
    next_fs = $(this).parents('fieldset:eq(0)').next();
    next_fs.show();
    current_fs.animate({opacity: 0}, {
    step: function(now) {
      opacity = 1 - now;
      current_fs.css({ 'display': 'none', 'position': 'relative' });
      next_fs.css({'opacity': opacity});
    }, duration: 500 });
    setProgressBar(++current);
  });

  //Progress Bar Previous
  $(document).on('click', ".previous",function(){
    current_fs = $(this).parents('fieldset:eq(0)');
    previous_fs = $(this).parents('fieldset:eq(0)').prev();
    previous_fs.show();
    current_fs.animate({opacity: 0}, {
      step: function(now) {
      opacity = 1 - now;
      current_fs.css({ 'display': 'none', 'position': 'relative' });
      previous_fs.css({'opacity': opacity});
    },  duration: 500 });
    setProgressBar(--current);
  });

  function setProgressBar(curStep){
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    $(".progress-bar").css("width",percent+"%")
  };
</script>
<style type="text/css">
  .error-class{color: red; display: none;}
</style>