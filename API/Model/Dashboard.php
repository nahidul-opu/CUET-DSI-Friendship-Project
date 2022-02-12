<?php
class Dashboard{
    //DB stuff
    private $conn;
    private $table1 = 'borrow';
    private $table2 = 'category';
    private $table3 = 'book';

    public $category_id;
    public $start_date;
    public $end_date;

    //constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }
    public function countCategory(){
        $query = 'SELECT COUNT(category_id)
        FROM category'; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function countBook(){
        $query = 'SELECT COUNT(book_id)
        FROM book';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
 } 