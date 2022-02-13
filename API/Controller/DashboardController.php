<?php
if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Dashboard.php');

class DashboardController
{
    private $db = null;
    private $requestMethod;
    private $startDate;
    private $endDate;
    private $dashboard;
    function __construct($dbConnector, $method, $queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        $this->dashboard = new Dashboard($this->db);
    }

    public function setStartingDate($date)
    {
        // print_r($date);
       $this->startDate = $date . ' 00:00:00';
    //    print_r($this->startDate);
    //    print("\n");
    }
    public function setEndingDate($date)
    {
        // print_r($date);
        $this->endDate = $date . " 23:59:59";
        // print_r($this->endDate);
    }

    // http://localhost:80/Library/CUET-DSI-Friendship-Project/API/Dashboard/22-02-07/22-02-07
    function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                // print_r($this->requestMethod);
                $response = $result =  $this->dashboard->getBooks($this->startDate,$this->endDate);
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


    private function handleGETRequests()
    {
        if (1)  $response =  $this->readBookData();
        else $response = $this->Responce('HTTP/1.1 404', 'Not Found', 'Invalid Request');
        return $response;
    }

    function __call($name_of_function, $arguments)
    {
        print_r("here");
        if ($name_of_function === 'readBookData') {
            print_r("here");
                    $result =  $this->dashboard->getBooks($this->startDate,$this->endDate);
                    // print_r($result);
                    if ($result) {
                        return $this->Responce('HTTP/1.1 200', 'OK', $result);
                    } else {
                        return $this->Responce('HTTP/1.1 404', 'Not Found', 'Empty Database');
                    }
        }
    }

    

    // private function validateInput($input)
    // {
    //     $hasRequired = $this->dashboard->hasRequiredField($input);
    //     if (!$hasRequired) {
    //         return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Missing Field(s)', 'isValid', false);
    //     }
    //     /*if (strlen($input['isbn']) != 17) {
    //         return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Invalid ISBN Data', 'isValid', false);
    //     }*/
    //     return $this->Responce('HTTP/1.1 200', 'OK', 'Valid', 'isValid', true);
    // }



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