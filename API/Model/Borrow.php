<?php
class Borrow
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
  //constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }
  public function read()
  {
    $query = 'SELECT borrow.book_id, borrow.user_id, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
          FROM 
            borrow, book, user
          WHERE book.book_id = borrow.book_id AND user.user_id=borrow.user_id
          ORDER BY
              created_at DESC;';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }
  public function delete()
  {
    $query = 'DELETE FROM borrow WHERE book_id=:book_id and user_id=:user_id';
    $stmt = $this->conn->prepare($query);

    $this->book_id = htmlspecialchars(strip_tags($this->book_id));
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));

    $stmt->bindParam(':book_id', $this->book_id);
    $stmt->bindParam(':user_id', $this->user_id);
    if ($stmt->execute()) {
      return true;
    }

    printf("Error:%s.\n", $stmt->error);

    return false;
  }
  public function readSpec()
  {
    $query = "SELECT *
        FROM 
          borrow 
        WHERE book_id=:book_id and user_id=:user_id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':book_id', $this->book_id);
    $stmt->bindParam(':user_id', $this->user_id);

    $stmt->execute();
    return $stmt;
  }
  public function readbyUser()
  {
    $query = "SELECT *
        FROM 
          borrow 
        WHERE user_id=:user_id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':user_id', $this->user_id);

    $stmt->execute();
    return $stmt;
  }
  public function readbyBookID()
  {
    $query = "SELECT *
        FROM 
          borrow 
        WHERE book_id=:book_id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':book_id', $this->book_id);

    $stmt->execute();
    return $stmt;
  }
}