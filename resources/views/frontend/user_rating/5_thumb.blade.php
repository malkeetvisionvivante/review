<?php 
  $lastDigit = explode('.', number_format($rate, 1))[1];;
?>
@if($rate < 1)
<span class="thumb fill-half-{{ $lastDigit }}"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
@elseif($rate >= 1 && $rate < 2)
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-half-{{ $lastDigit }}"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
@elseif($rate >= 2 && $rate < 3)
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-half-{{ $lastDigit }}"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
@elseif($rate >= 3 && $rate < 4)
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-half-{{ $lastDigit }}"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb "><i class="fas fa-thumbs-up text-green"></i></span>
@elseif($rate >= 4 && $rate < 5)
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-half-{{ $lastDigit }}"><i class="fas fa-thumbs-up text-green"></i></span>
@else
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
<span class="thumb fill-full"><i class="fas fa-thumbs-up text-green"></i></span>
@endif