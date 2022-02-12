<?php
if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Dashboard.php');
class DashboardController
{

    private $db = null;
    private $requestMethod;
    private $queryParams;
    private $dash;
    function __construct($dbConnector, $method, $queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        parse_str($queryString, $this->queryParams);
        $this->dash = new Dashboard($this->db);
    }
    function selectMethod()
    {
        if ($this->requestMethod == 'GET') {
            $this->countControl();
        }
    }
    public function countControl()
    {
        $this->dash->start=$this->queryParams['start'];
        $this->dash->end=$this->queryParams['end'];
        $stmt = $this->dash->countUser();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(
                array('message' => 'No entry')
            );
        }
    }
}