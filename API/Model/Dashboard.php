<?php
class Dashboard
{
  //DB stuff
  private $conn;
  private $table = 'borrow';
  //table stuff
  public $book_id;
  public $user_id;
  public $issue_date;
  public $due_date;
  public $created_at;
  public $updated_at;
  public $required = ['book_id', 'user_id'];
  //constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }
  public function countUser(){
    $query = "SELECT count(user_id)
    FROM user
    WHERE created_at BETWEEN '".$this->start." 12:00:00' AND '".$this->end." 12:00:00' ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}