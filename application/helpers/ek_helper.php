<?php

function blogDate($date){		
	$dates_arr = explode('-', $date);
	
	switch($dates_arr[1]){
		case "01":
			$dates_arr[1] = "January";
			break;
		case "02":
			$dates_arr[1] = "February";
			break;
		case "03":
			$dates_arr[1] = "March";
			break;
		case "04":
			$dates_arr[1] = "April";
			break;
		case "05":
			$dates_arr[1] = "May";
			break;
		case "06":
			$dates_arr[1] = "June";
			break;
		case "07":
			$dates_arr[1] = "July";
			break;
		case "08":
			$datea_arr[1] = "August";
			break;
		case "09":
			$dates_arr[1] = "September";
			break;
		case "10":
			$dates_arr[1] = "October";
			break;
		case "11":
			$dates_arr[1] = "November";
			break;
		case "12":
			$dates_arr[1] = "December";
			break;
		default:
			$dates_arr[1] = "N/A";
			break;
	}
	
	return $dates_arr;
}


/* gets the data from a URL */
function get_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


function geoCheckIP($ip)
       {
               //check, if the provided ip is valid
               if(!filter_var($ip, FILTER_VALIDATE_IP))
               {
                       throw new InvalidArgumentException("IP is not valid");
               }

               //contact ip-server
               $response=@file_get_contents('http://www.netip.de/search?query='.$ip);
               if (empty($response))
               {
                       throw new InvalidArgumentException("Error contacting Geo-IP-Server");
               }

               //Array containing all regex-patterns necessary to extract ip-geoinfo from page
               $patterns=array();
               $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
               $patterns["country"] = '#Country: (.*?)&nbsp;#i';
               $patterns["state"] = '#State/Region: (.*?)<br#i';
               $patterns["town"] = '#City: (.*?)<br#i';

               //Array where results will be stored
               $ipInfo=array();

               //check response from ipserver for above patterns
               foreach ($patterns as $key => $pattern)
               {
                       //store the result in array
                       $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
               }

               return $ipInfo;
       }

function forrstApiInfoJSON($user){

return 'var info = '.get_data('http://api.forrst.com/api/v2/users/info?username='.$user.'').'; 
		var JSON = JSON.stringify(info);';

}

function time_ago($datetime, $is_timestamp = false)
{
    if ($datetime === null) return;

    $timestamp  = $is_timestamp ? $datetime : strtotime($datetime);
    $difference = time() - $timestamp;
    $periods    = array("sec", "min", "hour", "day", "week", "month", "year", "decade");
    $lengths    = array("60","60","24","7","4.35","12","10");

    for($j = 0; $difference >= $lengths[$j]; $j++)
        $difference /= $lengths[$j];

    $difference = round($difference);
    if($difference != 1) $periods[$j].= "s";
    $text = "{$difference} {$periods[$j]} ago";
	
	if($text == "0 secs ago"){
		$text = "Just Now";
	}
	
    return $text;
}

function print__r($arr, $is_object = false){
	if(is_array($arr)){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}elseif($is_object = true){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}else{
		echo "please pass me an array of values or an object";
	}
}