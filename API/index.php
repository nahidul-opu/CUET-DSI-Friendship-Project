<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once('Config/DatabaseConnector.php');
require_once('Controller/BooksController.php');
require_once('Controller/CategoryController.php');
require_once('Controller/BorrowController.php');
require_once('Controller/UserController.php');
require_once('Controller/DashboardController.php');
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$uri = strtolower($uri);
$uri = explode('/api', $uri);
$uri = explode('/', $uri[1]);
$dbConnection = (new DatabaseConnector())->getConnection();
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($uri[1] == 'books') {
    $bookController = new BooksController($dbConnection, $requestMethod, $queryString);
    if (isset($uri[2])) {
        $bookController->setBookId($uri[2]);
    }
    $bookController->processRequest();
} else if ($uri[1] == 'category') {
    $categoryController = new CategoryController($dbConnection, $requestMethod, $queryString);
    if (isset($uri[2])) {
        $categoryController->setCategoryId($uri[2]);
    }
    $categoryController->processRequest();
} else if ($uri[1] == 'users') {
    $userController = new UsersController($dbConnection, $requestMethod, $queryString);
    if (isset($uri[2])) {
        $userController->setUserId($uri[2]);
    }
    $userController->processRequest();
} else if ($uri[1] == 'borrow' || $uri[1] == 'Borrow') {
    $borrowController = new BorrowController($dbConnection, $requestMethod, $queryString);
    /*if (isset($uri[2])) {
        $borrowController->readBorrows($uri[2]);
    }*/
    $borrowController->selectMethod();
} else if ($uri[1] == 'dashboard') {
    $dashboardController = new DashboardController($dbConnection, $requestMethod, $queryString);
    /*if (isset($uri[2])) {
        $borrowController->readBorrows($uri[2]);
    }*/
    $dashboardController->selectMethod();
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}