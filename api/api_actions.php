<?php
include_once "cache_functions.php";

//checks if Audio catalog exists
function checkAudioCatalog(){
    $stime = microtime(true);
    $path='/downloads/audio_all.xml';
    if(file_exists($path)){        
        apiResponse('Catalog exists', spent($stime));
    } else {
        failResponse('Catalog does not exists', spent($stime));
    }
}

//gets list of titles of Audio catalog
function getAudioTitles($offset, $length)
{
    $stime = microtime(true);
    $titles = getTitles("*"."audio::"."*", $offset, $length);        
    apiResponse(json_decode(json_encode($titles)), spent($stime));   
}

//finds all items in Audio catalog and returns array of JSON objects of metadata
function findInAudioTitles($search_pattern)
{
    $stime = microtime(true);
    $results = findInTitles("*"."audio::"."*", $search_pattern); 
    
    apiResponse($results, spent($stime));   
}


?>