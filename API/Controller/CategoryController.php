<?php

if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
// define('__ROOT__', dirname(dirname(__FILE__)));

require_once(__ROOT__ . '/Model/Category.php');

class CategoryController
{
    private $db = null;
    private $requestMethod;
    private $queryParams;
    private $category;

    function __construct($dbConnector, $method, $queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        parse_str($queryString, $this->queryParams);
        $this->category = new Category($this->db);
        $this->queryParams['category_id'] = null;
    }

    public function setCategoryId($id)
    {
        // print_r($id);
        $this->queryParams['category_id'] = $id;
    }

    function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if ($this->queryParams['category_id']) $this->raiseException();
                $response = $this->createCategory();
                break;
            case 'GET':
                // print_r("Get a dhukse");
                $response = $this->handleGETRequests();
                break;
            case 'PUT':
                if ($this->queryParams['category_id']) $response = $this->updateCategory($this->queryParams['category_id']);
                else $this->raiseException();
                break;
            case 'DELETE':
                if ($this->queryParams['category_id']) $response = $this->deleteCategory($this->queryParams['category_id']);
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


    
    private function createCategory()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->category->insert($input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 409', 'Duplicate Data', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Inserted 1 Row');
    }

    private function handleGETRequests()
    {
        // print_r($category);
        if ($this->queryParams['category_id'] && count($this->queryParams) === 1) $response =  $this->readCategoryData($this->queryParams['category_id']);
        else if (count($this->queryParams) === 1)  $response =  $this->readCategoryData();
        else if ($this->queryParams['category_id'] && count($this->queryParams) === 2) $response = $this->readCategoryDataSpecificColumns();
        else if (empty($this->queryParams['category_id']) && count($this->queryParams) > 1) $response = $this->readCategoryDataWithParams();
        else $response = $this->Responce('HTTP/1.1 404', 'Not Found', 'Invalid Request');
        
        return $response;
    }

    function __call($name_of_function, $arguments)
    {
        if ($name_of_function === 'readCategoryData') {

            switch (count($arguments)) {

                case 0:
                    $result =  $this->category->getCategorys();
                    if ($result) {
                        return $this->Responce('HTTP/1.1 200', 'OK', $result);
                    } else {
                        return $this->Responce('HTTP/1.1 404', 'Not Found', 'Empty Database');
                    }

                case 1:
                    $result =  $this->category->getCategory($arguments[0]);
                    if ($result) {
                        return $this->Responce('HTTP/1.1 200', 'OK', $result);
                    } else {
                        return $this->Responce('HTTP/1.1 404', 'Not Found', 'No Data For ' . $arguments[0]);
                    }
            }
        }
    }


    private function updateCategory($category_id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->category->update($category_id, $input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 500', 'Internel Server Error', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Updated 1 Row');
    }
    

    private function deleteCategory($category_id)
    {

        $result = $this->category->delete($category_id);
        if ($result) {
            return $this->Responce('HTTP/1.1 200', 'OK', $result);
        } else {
            return $this->Responce('HTTP/1.1 500', 'Internel Error', 'Failed');
        }
    }


    private function validateInput($input)
    {
        print_r($input);
        
        $hasRequired = $this->category->hasRequiredField($input);
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

?>