@if($data['score'] <= 0)
<span class="thumb"><i class="fas fa-thumbs-up text-muted border-muted"></i></span> {{ $data['score'] }} Company
@elseif($data['score'] < 3)
<span class="thumb"><i class="fas fa-thumbs-up text-red border-red"></i></span> {{ $data['score'] }} Company
@elseif($data['score'] >=3 && $data['score'] < 4)
<span class="thumb"><i class="fas fa-thumbs-up text-yellow border-yellow"></i></span> {{ $data['score'] }} Company
@else
<span class="thumb"><i class="fas fa-thumbs-up text-green border-green"></i></span> {{ $data['score'] }} Company
@endif