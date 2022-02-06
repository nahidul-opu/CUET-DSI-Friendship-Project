<?php

require_once('Config/DatabaseConnector.php');
require_once('Controller/BooksController.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


$dbConnection = (new DatabaseConnector())->getConnection();
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($uri[2] == 'book' || $uri[2] == 'Book') {
    $book_id = null;
    if (isset($uri[3])) {
        $book_id = $uri[3];
    }
    $controller = new BooksController($dbConnection, $requestMethod, $book_id);
    $controller->processRequest();
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}