<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once "utilities.php";

if(!isset($_SESSION)){session_start();}

//Actions
include "api_functions.php";
include "api_actions.php";

//Routes
include "api_router.php";

?>