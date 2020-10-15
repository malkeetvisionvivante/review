<?php 
$string = (string)$rate;
$lastDigit = (int)$string[0];
$lastDigit = $lastDigit * 2;
?>

<div class="thumb-sec"><span class="thumb fill-half-{{ $lastDigit }}"><i class="fas fa-thumbs-up text-green"></i></span> {{ $rate }}</div> <img src="{{ url('/images/manager-score-small.png') }}"> {{ $text }}
