<?php
class Dashboard
{
    //DB stuff
    private $conn;
    private $table1 = 'borrow';
    private $table2 = 'category';
    private $table3 = 'book';

    public $category_id;
    public $start_date;
    public $end_date;

    //constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function countCategory()
    {
        $query = 'SELECT COUNT(category_id)
        FROM category';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function countBook()
    {
        $query = 'SELECT COUNT(book_id)
        FROM book';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function totalUserAdded($start_date, $end_date)
    {
        $query = "SELECT COUNT(user_id) from user where created_at BETWEEN STR_TO_DATE('" . $start_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f') AND STR_TO_DATE('" . $end_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f');";
        //print_r($query);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function totalBorrowedReturned($start_date, $end_date)
    {
        $query = "SELECT COUNT(status) from borrow where (updated_at BETWEEN STR_TO_DATE('" . $start_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f') AND STR_TO_DATE('" . $end_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f'))
        AND (issue_date BETWEEN STR_TO_DATE('" . $start_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f') AND STR_TO_DATE('" . $end_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f'))
        GROUP BY status;";
        //print_r($query);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    public function totalBooksAdded($start_date, $end_date)
    {
        $query = "SELECT COUNT(book_id) from book where created_at BETWEEN STR_TO_DATE('" . $start_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f') AND STR_TO_DATE('" . $end_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f');";
        //print_r($query);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    public function totalOverduedBooks($start_date, $end_date)
    {
        $query = "SELECT COUNT(due_date) from borrow where due_date BETWEEN STR_TO_DATE('" . $start_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f') AND STR_TO_DATE('" . $end_date . "T00:00:00','%Y-%m-%dT%H:%i:%s.%f') AND status=0;";
        //print_r($query);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}