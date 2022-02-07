<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Book.php');

class BooksController
{
    private $db = null;
    private $requestMethod;
    private $queryParams;
    private $book;
    function __construct($dbConnector, $method, $queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        parse_str($queryString, $this->queryParams);
        //$this->queryParams = var_dump($this->queryParams);
        $this->book = new Book($this->db);
        $this->queryParams['book_id'] = null;
    }

    public function setBookId($id)
    {
        $this->queryParams['book_id'] = $id;
    }

    function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if ($this->queryParams['book_id']) $this->raiseException();
                $response = $this->createBook();
                break;
            case 'GET':
                $response = $this->handleGETRequests();
                break;
            case 'PUT':
                if ($this->queryParams['book_id']) $response = $this->updateBook($this->queryParams['book_id']);
                else $this->raiseException();
                break;
            case 'DELETE':
                if ($this->queryParams['book_id']) $response = $this->deleteBook($this->queryParams['book_id']);
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

    private function handleGETRequests()
    {
        if ($this->queryParams['book_id'] && count($this->queryParams) === 1) $response =  $this->readBookData($this->queryParams['book_id']);
        else if (count($this->queryParams) === 1)  $response =  $this->readBookData();
        else if ($this->queryParams['book_id'] && count($this->queryParams) === 2) $response = $this->readBookDataSpecificColumns();
        else if (empty($this->queryParams['book_id']) && count($this->queryParams) > 1) $response = $this->readBookDataWithParams();
        else $response = $this->Responce('HTTP/1.1 404', 'Not Found', 'Invalid Request');
        return $response;
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

    private function readBookDataWithParams()
    {
        $result = $this->book->getBookWithParams($this->queryParams);
        if ($result) {
            return $this->Responce('HTTP/1.1 200', 'OK', $result);
        } else {
            return $this->Responce('HTTP/1.1 404', 'Not Found', 'No Data Found');
        }
    }
    private function readBookDataSpecificColumns()
    {
        $result = $this->book->getBookWithSpecificColumns($this->queryParams['book_id'], $this->queryParams['columns']);
        if ($result) {
            return $this->Responce('HTTP/1.1 200', 'OK', $result);
        } else {
            return $this->Responce('HTTP/1.1 404', 'Not Found', 'No Data Found');
        }
    }

    private function updateBook($book_id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->book->update($book_id, $input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 500', 'Internel Server Error', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Updated 1 Row');
    }

    private function deleteBook($book_id)
    {

        $result = $this->book->delete($book_id);
        if ($result) {
            return $this->Responce('HTTP/1.1 200', 'OK', $result);
        } else {
            return $this->Responce('HTTP/1.1 500', 'Internel Error', 'Failed');
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