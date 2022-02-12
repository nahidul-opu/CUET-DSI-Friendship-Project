<?php

use function PHPSTORM_META\type;

if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Dashboard.php');

class DashboardController
{
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
        if ($this->requestMethod == 'GET') {
            $this->get_data();
        }
    }

    public function get_data()
    {
        $total_category = $this->readCount();
        $total_book = $this->dashboard->countBook()[0]['COUNT(book_id)'];
        $rni = $this->dashboard->totalBorrowedReturned($this->queryParams['start_date'], $this->queryParams['end_date']);
        $tba = $this->dashboard->totalBooksAdded($this->queryParams['start_date'], $this->queryParams['end_date']);
        $tdb = $this->dashboard->totalOverduedBooks($this->queryParams['start_date'], $this->queryParams['end_date']);
        $tua = $this->dashboard->totalUserAdded($this->queryParams['start_date'], $this->queryParams['end_date']);
        $result = array(
            "total_category" => $total_category,
            "total_book" => $total_book,
            "total_issued" => $rni[0]['COUNT(status)'],
            "total_returned" => $rni[1]['COUNT(status)'],
            "total_books_added" => $tba[0]['COUNT(book_id)'],
            "total_overdued_books" => $tdb[0]['COUNT(due_date)'],
            "total_user_added" => $tua[0]['COUNT(user_id)']
        );
        echo json_encode($result);
    }


    public function readCount()
    {
        $stmt = $this->dashboard->countCategory();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result[0]['COUNT(category_id)'];
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