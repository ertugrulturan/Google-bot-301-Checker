<?php
// ERTUGRUL TURAN
error_reporting(E_ALL);
set_time_limit(2000);
$dosya = file('sitelist.txt');
$nodes = $dosya;
$node_count = count($nodes);
$curl_arr = array();
$domainler = array();
$infolar = array();
$master = curl_multi_init();
for($i = 0; $i < $node_count; $i++)
{
    $url = trim($nodes[$i]);
	$domainler[$i] = $url; 
    $curl_arr[$i] = curl_init($url);
	
    curl_setopt($curl_arr[$i], CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt($curl_arr[$i], CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($curl_arr[$i], CURLOPT_HEADER, true);
    curl_setopt($curl_arr[$i], CURLOPT_USERAGENT, "Googlebot/2.1 (+http://www.googlebot.com/bot.html)");
    curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
	//$infolar[$i] = curl_getinfo($curl_arr[$i]);
    curl_multi_add_handle($master, $curl_arr[$i]);
}

do {
    curl_multi_exec($master,$running);
} while($running > 0);


for($i = 0; $i < $node_count; $i++)
{
	//echo $domainler[$i];
	//echo print_r($infolar[$i]);
	//var_dump(curl_multi_info_read($curl_arr[$i]));
    $icerik = curl_multi_getcontent  ( $curl_arr[$i]  );
	preg_match('#Location: (.*?)Server#si',$icerik,$verx);
	if (isset($verx[1])) {
		echo "bu domain $domainler[$i] => $verx[1] buraya yonlendirildi <br />";
		
	}
	
	
	
}


















