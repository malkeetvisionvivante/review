@if($rate == 1)
<i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-red border-red question question_{{$question->id}}_1"></i> 
<i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_2"></i> 
<i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_3"></i> 
<i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_4"></i> 
<i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_5"></i>
@elseif($rate == 2)
<i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-red border-red question question_{{$question->id}}_1"></i> 
<i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-red border-red question question_{{$question->id}}_2"></i> 
<i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_3"></i> 
<i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_4"></i> 
<i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_5"></i>
@elseif($rate == 3)
<i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-yellow border-yellow question question_{{$question->id}}_1"></i> 
<i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-yellow border-yellow question question_{{$question->id}}_2"></i> 
<i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-yellow border-yellow question question_{{$question->id}}_3"></i> 
<i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_4"></i> 
<i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_5"></i>
@elseif($rate == 4)
<i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_1"></i> 
<i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_2"></i> 
<i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_3"></i> 
<i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_4"></i> 
<i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_5"></i>
@elseif($rate == 5)
<i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_1"></i> 
<i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_2"></i> 
<i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_3"></i> 
<i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_4"></i> 
<i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-green border-green question question_{{$question->id}}_5"></i>
@else
<i data="1" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_1"></i> 
<i data="2" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_2"></i> 
<i data="3" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_3"></i> 
<i data="4" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_4"></i> 
<i data="5" data-que="{{$question->id}}" class="fas fa-thumbs-up text-muted question question_{{$question->id}}_5"></i>
@endif