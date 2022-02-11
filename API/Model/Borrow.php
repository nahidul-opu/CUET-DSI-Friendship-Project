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
  public $required = ['book_id', 'user_id'];
  //constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }
  function hasRequiredField($input)
  {
    foreach ($this->required as $item) {
      if (empty($input[$item])) {
        return false;
      }
    }
    return true;
  }
  public function read()
  {
    $query = 'SELECT borrow.book_id, borrow.status, borrow.user_id, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
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
    $query = "SELECT borrow.book_id, borrow.user_id,borrow.status, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
    FROM 
      borrow, book, user
    WHERE borrow.book_id=:book_id and borrow.user_id=:user_id AND book.book_id = borrow.book_id AND user.user_id=borrow.user_id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':book_id', $this->book_id);
    $stmt->bindParam(':user_id', $this->user_id);

    $stmt->execute();
    return $stmt;
  }
  public function readbyUser()
  {
    $query = "SELECT borrow.book_id, borrow.user_id,borrow.status, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
    FROM 
      borrow, book, user
    WHERE borrow.user_id=:user_id AND book.book_id = borrow.book_id AND user.user_id=borrow.user_id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':user_id', $this->user_id);

    $stmt->execute();
    return $stmt;
  }
  public function readbyBookID()
  {
    $query = "SELECT borrow.book_id, borrow.user_id,borrow.status, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
    FROM 
      borrow, book, user
    WHERE book.book_id=:book_id  AND book.book_id = borrow.book_id AND user.user_id=borrow.user_id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':book_id', $this->book_id);
    $stmt->execute();
    return $stmt;
  }
  public function readbyBookName()
  {
    $query = "SELECT borrow.book_id, borrow.user_id,borrow.status, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
    FROM 
      borrow, book, user
    WHERE book.title=:title  AND book.book_id = borrow.book_id AND user.user_id=borrow.user_id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':title', $this->title);
    $stmt->execute();
    return $stmt;
  }
  public function readbyLimit()
  {
    if(isset($this->offset)){
      $query = "SELECT borrow.book_id, borrow.status, borrow.user_id, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
    FROM 
      borrow, book, user
    WHERE book.book_id = borrow.book_id AND user.user_id=borrow.user_id LIMIT 
    ".$this->LIMIT." OFFSET ".$this->offset." ";
    }
    else{
    $query = "SELECT borrow.book_id, borrow.status, borrow.user_id, borrow.issue_date, borrow.due_date, book.title, user.name, borrow.created_at, borrow.updated_at
    FROM 
      borrow, book, user
    WHERE book.book_id = borrow.book_id AND user.user_id=borrow.user_id LIMIT 
    ".$this->LIMIT." ";
    }
    $stmt = $this->conn->prepare($query); 
    $stmt->execute();
    return $stmt;
  }
  public function create($input)
  {
    $statement = "
            INSERT INTO borrow 
                (book_id, user_id, issue_date, due_date, created_at,updated_at)
            VALUES
                (:book_id, :user_id, now(),(DATE_ADD(now(),interval 20 day)), now(),now());
        ";

    try {
      $statement = $this->conn->prepare($statement);
      $result = $statement->execute(array(
        'book_id' => $input['book_id'],
        'user_id' => $input['user_id'],
      ));
      $response['success'] = true;
      if ($result === false) {
        $response['success'] = false;
        $response['error'] = $statement->errorInfo()[2];
      }
      return $response;
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }

  public function update($params)
  {
    $statement = "";
    if (isset($params['renew'])) {
      $statement = "
        UPDATE borrow 
        SET  due_date=(DATE_ADD(now(),interval 20 day)) ,updated_at=now()
        WHERE book_id=:book_id AND user_id=:user_id;
      ";
    } else if (isset($params['return'])) {
      $statement = "
          UPDATE borrow 
          SET  status = 1 ,updated_at=now()
          WHERE book_id=:book_id AND user_id=:user_id;
        ";
    }
    try {
      $statement = $this->conn->prepare($statement);
      $result = $statement->execute(array(
        'book_id' => $this->book_id,
        'user_id' => $this->user_id,
      ));
      $response['success'] = true;
      if ($result === false) {
        $response['success'] = false;
        $response['error'] = $statement->errorInfo()[2];
      }
      return $response;
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }
}