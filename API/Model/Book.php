<?php

class Book
{
    protected $db;

    protected $required = ['ISBN', 'Title', 'AuthorName', 'PubYear', 'TotalCount', 'Publisher', 'CategoryID'];

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
    }

    public function insert($input)
    {
        $statement = "
        INSERT INTO book 
            (ISBN, Title, AuthorName, PubYear, TotalCount,CurrentCount,Publisher,CategoryID)
        VALUES
            (:ISBN, :Title, :AuthorName, :PubYear,:TotalCount,:TotalCount,:Publisher,:CategoryID);
    ";

        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'ISBN' => $input['ISBN'],
                'Title' => $input['Title'],
                'AuthorName' => $input['AuthorName'],
                'PubYear' => $input['PubYear'],
                'TotalCount' => $input['TotalCount'],
                'Publisher' => $input['Publisher'],
                'CategoryID' => $input['CategoryID'],
            ));

            if ($statement->rowCount() == 0) return false;
            else return true;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getBook($isbn)
    {
        $statement = "
        SELECT * 
        FROM book
        WHERE ISBN=:ISBN
    ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'ISBN' => $isbn,
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