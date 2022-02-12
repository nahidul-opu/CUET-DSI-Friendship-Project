<?php
if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Dashboard.php');

class DashboardController{
    private $db = null;
    private $requestMethod;
    private $queryParams;
    private $dashboard;
    function __construct($dbConnector, $method, $queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        parse_str($queryString, $this->queryParams);
        $this->dashboard = new Dashboard($this->db);
    }

    function selectMethod()
    {
        if ($this->requestMethod == 'GET')
        {
            $this->readCount();
        }
    }
    public function readCount()
    {
        $stmt = $this->dashboard->countCategory();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(
                array('message' => 'No book issue history found')
            );
    
        }
        $stmt = $this->dashboard->countBook();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(
                array('message' => 'No book issue history found')
            );
    
        }
    }
}
?>