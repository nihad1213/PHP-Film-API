<?php

// Get URI
$URI =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


// Divide URI to get Specific part
$part = explode('/', $URI);

$resource = $part[3];
$id = $part[4] ?? null;

// If there is no 'film' in URI give 404 error
if ($resource !== "film") {
    http_response_code(404);
    exit;
}

// If there is film do this things
