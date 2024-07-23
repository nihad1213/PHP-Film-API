<?php

//Show errors
ini_set("display_errors", "On");

header("Content-type: application/json; charset=UTF-8");

require dirname(__DIR__) . "/vendor/autoload.php";

$dotnev = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotnev->load();