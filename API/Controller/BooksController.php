<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Book.php');

class BooksController
{
    private $db = null;
    private $requestMethod;
    private $isbn;
    private $book;
    function __construct($dbConnector, $method, $isbn)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        if ($isbn) $this->isbn = $isbn;
        $this->book = new Book($this->db, $this->isbn);
    }

    function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createBook();
                break;
            case 'GET':
                if ($this->isbn) $response =  $this->readBookData($this->isbn);
                else  $response =  $this->readBookData();
                break;
            case 'PUT':
                if ($this->isbn) print_r("Updating " . $this->isbn);
                else $this->raiseException();
                break;
            case 'DELETE':
                if ($this->isbn) print_r("Deleting " . $this->isbn);
                else $this->raiseException();
                break;
            default:
                $this->raiseException();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function createBook()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->book->insert($input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 409', 'Duplicate Data', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Inserted 1 Row');
    }

    function __call($name_of_function, $arguments)
    {
        if ($name_of_function === 'readBookData') {

            switch (count($arguments)) {

                case 0:
                    $result =  $this->book->getBooks();
                    if ($result) {
                        return $this->Responce('HTTP/1.1 200', 'OK', $result);
                    } else {
                        return $this->Responce('HTTP/1.1 404', 'Not Found', 'Empty Database');
                    }

                case 1:
                    $result =  $this->book->getBook($arguments[0]);
                    if ($result) {
                        return $this->Responce('HTTP/1.1 200', 'OK', $result);
                    } else {
                        return $this->Responce('HTTP/1.1 404', 'Not Found', 'No Data For ' . $arguments[0]);
                    }
            }
        }
    }

    private function validateInput($input)
    {
        $hasRequired = $this->book->hasRequiredField($input);
        if (!$hasRequired) {
            return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Missing Field(s)', 'isValid', false);
        }
        /*if (strlen($input['isbn']) != 17) {
            return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Invalid ISBN Data', 'isValid', false);
        }*/
        return $this->Responce('HTTP/1.1 200', 'OK', 'Valid', 'isValid', true);
    }



    function raiseException()
    {
        print_r("Invalid API or Request Method");
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    private function Responce($headerCode, $headerMsg, $bodyMsg, $customKey = null, $customValue = null)
    {
        $response['status_code_header'] = $headerCode . ' ' . $headerMsg;
        if ($customKey)
            $response[$customKey] = $customValue;
        $response['body'] = json_encode([
            'message' => $bodyMsg
        ]);
        return $response;
    }
}