<?php
  class Borrow{
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
      public function __construct($db){
          $this->conn = $db;
      }
      public function read(){
          $query = 'SELECT u.name as user_name,
          b.title as book_title,
          br.book_id,
          br.user_id,
          br.issue_date,
          br.issue_date,
          br.due_date,
          br.created_at,
          br.updated_at
        FROM 
          ' .$this->table.' br
        LEFT JOIN
           book b ON br.book_id=b.book_id
        LEFT JOIN
            user u ON br.user_id=u.user_id
        ORDER BY
            br.created_at DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;

      }

  }


?>