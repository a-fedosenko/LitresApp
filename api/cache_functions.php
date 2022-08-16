<?php

$audio_pattern = "*"."audio::"."*";

//creates cache for Audio catalog
function cacheAudio()
{
    global $audio_pattern;

    //read xml
    $path = '/downloads/audio_all.xml';
    $xml = simplexml_load_file($path) or die("Error: Cannot create object");
    $offers = $xml->shop->offers->children();

    //change cache only if xml was read successfully
    if(sizeof($offers)>0){        
        $redis = openCache();
        if($redis){
            //clean up cache from previous version
            //for hard reset use $redis->flushAll(); 
            foreach($redis->keys($audio_pattern) as $key) $redis->del($key); 
            foreach($offers as $offer){   
                if($offer['id']){                    
                    addToCache($redis, "audio::".$offer['id']."::".$offer->name, json_encode($offer, JSON_UNESCAPED_UNICODE));
                }
            }        
        }
        $redis->disconnect();        
    }    
}

//starts connection to Redis
function openCache(){
    try {
        $redis = new \Predis\Client([
            'host' => 'redis' 
        ]);
        return $redis;
    } catch (Exception $e) {        
        return null;
    }
}

//adds key-value to cache
function addToCache($redis, $key, $value)
{
    try {
        $redis->set($key, $value);
    } catch (Exception $e) {}
}

//finds needle in cache
function searchInCache($needle)
{
    $redis = openCache();    
    $results = $redis->keys('*'.$needle.'*');
    $redis->disconnect();
    return $results;
}

//gets list of titles with pagination
//offset - start position
//length - number of items on page
function getTitles($key_pattern, $offset, $length)
{     
    $redis = openCache();    
    $keys = $redis->keys('*audio::*');
    $keys = array_slice($keys, $offset, $length);
    for($i=0;$i<sizeof($keys);$i++)
    {
        $key_arr = explode('::', $keys[$i]);
        $keys[$i] = $key_arr[2];
    }
    $redis->disconnect();
    return $keys;
}

//returns array of JSONs of found items with search pattern
//key pattern allows to filter in cache
function findInTitles($key_pattern, $search_pattern)
{     
    $redis = openCache();   
    $keys = $redis->keys($key_pattern.$search_pattern.'*');
    $results = [];
    for($i=0;$i<sizeof($keys);$i++)
    {
        $results[] = json_decode($redis->get($keys[$i]));
    }
    $redis->disconnect();
    return $results;
}

?>