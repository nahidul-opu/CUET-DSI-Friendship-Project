<?php

require_once('Config/DatabaseConnector.php');
require_once('Controller/BooksController.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$uri = explode('/', $uri);

$dbConnection = (new DatabaseConnector())->getConnection();
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($uri[2] == 'books' || $uri[2] == 'Books') {
    $bookController = new BooksController($dbConnection, $requestMethod, $queryString);
    if (isset($uri[3])) {
        $bookController->setBookId($uri[3]);
    }
    $bookController->processRequest();
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}