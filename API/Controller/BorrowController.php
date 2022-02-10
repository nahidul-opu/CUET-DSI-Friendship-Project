<?php
if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Borrow.php');
class BorrowController
{

    private $db = null;
    private $requestMethod;
    private $queryParams;
    private $borrow;
    function __construct($dbConnector, $method, $queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        parse_str($queryString, $this->queryParams);
        $this->borrow = new Borrow($this->db);
    }
    function selectMethod()
    {
        if ($this->requestMethod == 'GET') {
            if (count($this->queryParams) > 0) {
                if (isset($this->queryParams['book_id']) && isset($this->queryParams['user_id']) && count($this->queryParams) === 2) {
                    $this->readBorrows();
                }
                if (isset($this->queryParams['user_id']) && count($this->queryParams) === 1) {
                    $this->readBorrowUser();
                }
                if (isset($this->queryParams['book_id']) && count($this->queryParams) === 1) {
                    $this->readBorrowbyBook();
                }
            } else $this->readBorrow();
        } else if ($this->requestMethod == 'DELETE') {
            $this->delete();
        } else if ($this->requestMethod == 'POST') {
            $this->createBorrow();
        } else if ($this->requestMethod == 'PUT') {
            $response = $this->updateBorrow();
        }
    }

    public function readBorrow()
    {
        $result = $this->borrow->read();
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(
                array('message' => 'No book issue history found')
            );
        }
    }
    public function delete()
    {
        $this->borrow->book_id = $this->queryParams['book_id'];
        $this->borrow->user_id = $this->queryParams['user_id'];
        if ($this->borrow->delete()) {
            echo json_encode(array("message" => "Product was deleted."));
        } else {
            echo json_encode(array("message" => "Unable to delete product."));
        }
    }

    public function readBorrows()
    {
        $this->borrow->book_id = $this->queryParams['book_id'];
        $this->borrow->user_id = $this->queryParams['user_id'];
        $stmt = $this->borrow->readSpec();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(
                array('message' => 'No book issue history found')
            );
        }
    }
    public function readBorrowUser()
    {
        $this->borrow->user_id = $this->queryParams['user_id'];
        $stmt = $this->borrow->readbyUser();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(
                array('message' => 'No book issue history found')
            );
        }
    }
    public function readBorrowbyBook()
    {
        $this->borrow->book_id = $this->queryParams['book_id'];
        $stmt = $this->borrow->readbyBookID();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(
                array('message' => 'No book issue history found')
            );
        }
    }
    public function createBorrow()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->borrow->create($input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 409', 'Duplicate Data', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Inserted 1 Row');
    }
    public function updateBorrow()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $this->borrow->book_id = $input['book_id'];
        $this->borrow->user_id = $input['user_id'];
        $response = $this->borrow->update($this->queryParams);
        if (!$response['success']) return $this->Responce('HTTP/1.1 500', 'Internel Server Error', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Updated 1 Row');
    }
    public function validateInput($input)
    {
        $hasRequired = $this->borrow->hasRequiredField($input);
        if (!$hasRequired) {
            return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Missing Field(s)', 'isValid', false);
        }
        return $this->Responce('HTTP/1.1 200', 'OK', 'Valid', 'isValid', true);
    }
    public function Responce($headerCode, $headerMsg, $bodyMsg, $customKey = null, $customValue = null)
    {
        $response['status_code_header'] = $headerCode . ' ' . $headerMsg;
        if ($customKey)
            $response[$customKey] = $customValue;
        $response['body'] = json_encode([
            'message' => $bodyMsg
        ]);
        return $response;
    }
    function raiseException()
    {
        print_r("Invalid API or Request Method");
        header("HTTP/1.1 404 Not Found");
        exit();
    }
}