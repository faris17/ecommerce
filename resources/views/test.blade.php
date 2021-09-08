@php

$date = \Carbon\Carbon::now(); // will get you the current date, time
$data = explode('-', $date->format('Y-m-d'));
$random = substr(hash('sha256', mt_rand() . microtime()), 0, 3);
echo $data[0] . $data[1] . $data[2] . $random;
@endphp
