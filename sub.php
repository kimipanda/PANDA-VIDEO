<?php
header("Content-Type: text/vtt; charset=UTF-8");

function samiTime2vttTime($samiTime)
{
 $sec = fmod($samiTime / 1000, 60);
 $min = $samiTime / 1000 / 60 % 60;
 $hour = $samiTime / 1000 / 60 / 60;
 return sprintf("%02d:%02d:%06.3f", $hour, $min, $sec);
}

$fp = fopen($_GET['src'], "r");
$cont = "";
while (!feof($fp))
{
 $cont .= fread($fp, 500);
}
fclose($fp);

//$cont = iconv("euc-kr","UTF-8", $cont);
//echo $cont;
//
$pattern = "/<SYNC Start=(?<time>\d*)[^>]*><P Class=(?<lang>\w*)[^>]*>(?<text>.*&nbsp;|.*\n.*[^<SYNC]*)/i";
preg_match_all($pattern, $cont, $out,  PREG_SET_ORDER);


$beginTime = 0;
$endTime = 0;
$index = 0;
echo "WEBVTT\n\n";

foreach ($out as $val) {
 $beginTime = $val['time'];
 $endTime = $out[$index+1]['time'];
 $text = trim($val['text']);
 if($text != '&nbsp;')
 {
 $text = preg_replace("/<br>|<br\/>/i", "", $text);
 echo samiTime2vttTime($beginTime)." --> ".samiTime2vttTime($endTime)."\n";
 echo $text."\n\n";
 }
 ++$index;
}
?>
