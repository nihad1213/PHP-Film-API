<?php

require __DIR__.  '/bootstrap.php';

// Get URI
$URI =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


// Divide URI to get Specific part
$part = explode('/', $URI);

$resource = $part[3];
$id = $part[4] ?? null;

if (empty($_SERVER['HTTP_X_API_KEY'])) {
    http_response_code(400  );
    echo json_encode(["error" => "missing api key"]);
    exit;
}

$api_key = $_SERVER['HTTP_X_API_KEY'];

// Add database
$database = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$database->getConnect();

$userGateway = new UserGateway($database);
if ($userGateway->getByAPIKey($api_key) === false) {

    http_response_code(401);
    echo json_encode(["message" => "invalid API KEY"]);
    exit;

}

// If there is no 'film' in URI give 404 error
if ($resource !== "film") {
    http_response_code(404);
    exit;
}

// If there is film do this things
$filmGateway = new FilmGateway($database);
$controller = new FilmController($filmGateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);