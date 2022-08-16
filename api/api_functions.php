<?php

//Shared API functions

//successfull response
function apiResponse($rslt, $time){
	if($rslt){
		echo response("OK", $rslt, 200, $time);	
	} else {
		echo response("Error", "No response from external API server", 500, $time);
	}	
}

//failure response
function failResponse($message, $code = 400){
	$rslt = json_decode(json_encode($message));
	$time = microtime(true) - $stime;
	echo response("Failed", $rslt, $code, $time);
}


//check functions - not used for now 
function check_api_key($api_key){
	if(empty($api_key)){
		failResponse('No API key');
		return false;
	}
	return true;
}

//Router functions

//compares request uri against route patterns
function route($route, $route_method)
{
	global $uri, $uri_array, $method; 
	if($uri == $route && $method == $route_method) return true;
	$route_array = explode('/', $route);
	if(sizeof($route_array) == sizeof($uri_array)){
		for($i=1; $i<sizeof($route_array); $i++){
			$reg_ex = "/".$route_array[$i]."/";
			if(!preg_match($reg_ex, $uri_array[$i])) return false;
		}
		return true;
	}
	return false;
}

//response
function response($code, $mess, $httpcode, $time)
{
	http_response_code($httpcode);
	$response['code'] = $code;
	$response['message'] = $mess;
	$response['time'] = $time;
	$response['status'] = $httpcode;
	$json_response = json_encode($response);
	echo $json_response;
}

//time spent
function spent($stime=null){
	if(empty($stime)) $stime = microtime(true);
	$time = microtime(true) - $stime;
	return $time;
}

//xml element conversion - for debugging
function xml_to_JSON($xml_string){
    $xml = simplexml_load_string($xml_string);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
}

?>
