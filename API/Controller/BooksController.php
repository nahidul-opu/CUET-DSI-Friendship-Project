<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Book.php');

class BooksController
{
    private $db = null;
    private $requestMethod;
    private $book_id;
    private $book;
    function __construct($dbConnector, $method, $book_id)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        if ($book_id) $this->book_id = $book_id;
        $this->book = new Book($this->db, $this->book_id);
    }

    function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if ($this->book_id) $this->raiseException();
                $response = $this->createBook();
                break;
            case 'GET':
                if ($this->book_id) $response =  $this->readBookData($this->book_id);
                else  $response =  $this->readBookData();
                break;
            case 'PUT':
                if ($this->book_id) $response = $this->updateBook($this->book_id);
                else $this->raiseException();
                break;
            case 'DELETE':
                if ($this->book_id) $response = $this->deleteBook($this->book_id);
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

    private function updateBook($book_id)
    {
        print_r("Updating " . $book_id);
        return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Not Implemented');
    }

    private function deleteBook($book_id)
    {

        print_r("Deleting " . $book_id);
        return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Not Implemented');
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