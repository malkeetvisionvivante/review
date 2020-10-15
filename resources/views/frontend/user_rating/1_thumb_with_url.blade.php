<?php 
$string = (string)$rate;
$lastDigit = (int)$string[0];
$lastDigit = $lastDigit * 2;
$rate = number_format((float)$rate, 1, '.', '');
?>

<span class="thumb fill-half-{{ $lastDigit }}"><i class="fas fa-thumbs-up text-green"></i></span> <a class="" href="{{ $url }}">{{ $rate }} </a>
