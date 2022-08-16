<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_array = explode('/', $uri );
$method = $_SERVER['REQUEST_METHOD'];

//Routes

header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");

switch(true)
{		
	//checks that api works	
	case route("/api/v0/hello", "GET"): 
		apiResponse('Hello there!', 0); 
		break;

	//checks if catalog exists	
	case route("/api/v0/audio/check", "GET"): 
		checkAudioCatalog(); 
		break;

	//gets titles (with pagination)	
	case route("/api/v0/audio/titles/[0-9]{1,6}/[0-9]{1,6}", "GET"): 
		$offset = intval($uri_array[5]);
		$length = intval($uri_array[6]);
		getAudioTitles($offset, $length); 
		break;
	
	//searches in titles 	
	case route("/api/v0/audio/titles/search/(.+)", "GET"): 
		$search_pattern = urldecode($uri_array[6]); 	
		findInAudioTitles($search_pattern); 
		break;
		

	default:
		response("Error", "Unsupported request for Litres API", 404, 0);	
		break;
}

?>