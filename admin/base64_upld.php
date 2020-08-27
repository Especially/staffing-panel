<?php
ini_set("log_errors", 1);

function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}
function generateRandomString($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
function base64_to_jpeg($Match) {
$rand = generateRandomString(17);
$ran = generateRandomString(7);
$tstamp = date("dmyHi");
$output_file = $rand."_".$tstamp."_".$ran;
$type = get_string_between($Match[0], "image/", ";");
$output_dir = "../images/";
	$output_file = "$output_dir$output_file.$type";
    $ifp = fopen($output_file, "wb"); 

    $data = explode(',', $Match[0]);

    fwrite($ifp, base64_decode($data[1])); 
    fclose($ifp); 

    return ('src="'.$output_file.'"'); 
}
?>