<?php
if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/User.php');

class UsersController
{
    private $db = null;
    private $requestMethod;
    private $queryParams;
    private $user;
    function __construct($dbConnector, $method, $queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        parse_str($queryString, $this->queryParams);
        $this->user = new User($this->db);
        $this->queryParams['user_id'] = null;
    }

    public function setUserId($id)
    {
        $this->queryParams['user_id'] = $id;
    }

    function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if ($this->queryParams['user_id']) $this->raiseException();
                $response = $this->createUser();
                break;
            case 'GET':
                // print_r("ashci");
                $response = $this->handleGETRequests();
                break;
            case 'PUT':
                if ($this->queryParams['user_id']) $response = $this->updateUser($this->queryParams['user_id']);
                else $this->raiseException();
                break;
            case 'DELETE':
                if ($this->queryParams['user_id']) $response = $this->deleteUser($this->queryParams['user_id']);
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

    private function createUser()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);

        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->user->insert($input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 409', 'Duplicate Data', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Inserted 1 Row');
    }

    private function handleGETRequests()
    {
        if ($this->queryParams['user_id'] && count($this->queryParams) === 1){ 
           
            $response =  $this->readUserData($this->queryParams['user_id']);
        }
            else if (count($this->queryParams) === 1) { 
               
                $response =  $this->readUserData();
            }
        else $response = $this->Responce('HTTP/1.1 404', 'Not Found', 'Invalid Request');
        return $response;
    }

    function __call($name_of_function, $arguments)
    {
        if ($name_of_function === 'readUserData') {

            switch (count($arguments)) {

                case 0:
                    $result =  $this->user->getUsers();
                    if ($result) {
                        return $this->Responce('HTTP/1.1 200', 'OK', $result);
                    } else {
                        return $this->Responce('HTTP/1.1 404', 'Not Found', 'Empty Database');
                    }

                case 1:
                    $result =  $this->user->getUser($arguments[0]);
                    if ($result) {
                        return $this->Responce('HTTP/1.1 200', 'OK', $result);
                    } else {
                        return $this->Responce('HTTP/1.1 404', 'Not Found', 'No Data For ' . $arguments[0]);
                    }
            }
        }
    }

    private function updateUser($user_id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->user->update($user_id, $input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 500', 'Internel Server Error', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Updated 1 Row');
    }

    private function deleteUser($user_id)
    {

        $result = $this->user->delete($user_id);
        if ($result) {
            return $this->Responce('HTTP/1.1 200', 'OK', $result);
        } else {
            return $this->Responce('HTTP/1.1 500', 'Internel Error', 'Failed');
        }
    }

    private function validateInput($input)
    {
        // print_r($input);
        $hasRequired = $this->user->hasRequiredField($input);
        if (!$hasRequired) {
            return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Missing Field(s)', 'isValid', false);
        }
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