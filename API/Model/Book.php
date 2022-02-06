<?php

class Book
{
    protected $db;

    protected $required = ['isbn', 'title', 'author_name', 'pub_year', 'total_count', 'publisher', 'category_id'];

    function __construct($dbConnnector)
    {
        $this->db = $dbConnnector;
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

    public function insert($input)
    {
        $statement = "
        INSERT INTO book 
            (isbn, title, author_name, pub_year, total_count,current_count,publisher,category_id,created_at,updated_at)
        VALUES
            (:isbn, :title, :author_name, :pub_year,:total_count,:total_count,:publisher,:category_id,now(),now());
    ";

        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'isbn' => $input['isbn'],
                'title' => $input['title'],
                'author_name' => $input['author_name'],
                'pub_year' => $input['pub_year'],
                'total_count' => $input['total_count'],
                'publisher' => $input['publisher'],
                'category_id' => $input['category_id'],
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

    public function getBook($book_id)
    {
        $statement = "
        SELECT * 
        FROM book
        WHERE book_id=:book_id
    ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'book_id' => $book_id,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function getBooks()
    {
        $statement = "
        SELECT * 
        FROM book
    ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}