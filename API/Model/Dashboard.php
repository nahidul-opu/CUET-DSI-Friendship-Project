<?php

class Dashboard
{
    protected $db;

    function __construct($dbConnnector)
    {
        $this->db = $dbConnnector;
    }

    public function getBooks($l, $r)
    {
       print_r($l);
       print("\n");
       print_r($r);
       print("\n"); 
        $statement = "
        SELECT * 
        FROM book
        WHERE updated_at BETWEEN $l AND $r;
    ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'updated_at' => $l,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


  
}