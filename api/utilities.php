<?php

//debug functions
function dump($object, $log_name = "", $append = false){        
	write_log(print_r($object, true), $log_name, $append);        
}
function dump_($object){        
	dump($object, "log", true);        
}
function write_log($log_text, $log_name = "", $append = true){ 
	if(empty($log_name)) $log_name = "log";
	$log_name="/"."downloads/".$log_name.".txt";
	$mode ="w";
	if($append) $mode = "a";
	$file = fopen($log_name, $mode) or die(false);
	fwrite($file, print_r($log_text, true)."\n");
	fclose($file);        
}

?>