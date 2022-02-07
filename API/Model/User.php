<?php

class User
{
    protected $db;

    protected $required = [
        'isbn', 'title', 'author_name', 'pub_year',
        'total_count', 'publisher', 'category_id'
    ];
    protected $allowedParams = [
        'isbn', 'title', 'author_name', 'pub_year',
        'total_count', 'current_count', 'publisher',
        'category_id', 'created_at', 'updated_at'
    ];
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
        INSERT INTO user 
            (email, name, borrow_count, contact_no , image_path,fine,created_at,updated_at)
        VALUES
            (:email, :name, :borrow_count, :contact_no ,:image_path,:fine,now(),now());
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

    public function getUser($user_id)
    {
        $statement = "
        SELECT * 
        FROM user
        WHERE user_id=:user_id
    ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'user_id' => $user_id,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function getUsers()
    {
        $statement = "
        SELECT * 
        FROM user
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

    // public function getBookWithParams($params)
    // {
    //     if (isset($params['sort']) && isset($params['column'])) {
    //         $statement = "
    //         SELECT * 
    //         FROM book ORDER BY " . $params['column'];
    //         if (isset($params['desc']) && $params['desc'] = true) {
    //             $statement = $statement . " DESC";
    //         }
    //         if (isset($params['limit'])) {
    //             $statement = $statement . " limit " . $params['limit'];
    //             if (isset($params['offset'])) $statement = $statement . " offset " . $params['offset'];
    //         }
    //         return $this->executeQuery($statement);
    //     } else if (isset($params['limit'])) {
    //         $statement = "
    //         SELECT * 
    //         FROM book limit " . $params['limit'];
    //         if (isset($params['offset'])) $statement = $statement . " offset " . $params['offset'];
    //         return $this->executeQuery($statement);
    //     } else if (isset($params['column']) && isset($params['value']) && in_array($params['column'], $this->allowedParams)) {
    //         $statement = "
    //             SELECT * 
    //             FROM book
    //             WHERE " . $params['column'];
    //         if (isset($params['like']))
    //             $statement = $statement . " LIKE '%" . $params['value'] . "%';";
    //         else $statement = $statement . "=" . $params['value'] . ";";
    //         return $this->executeQuery($statement);
    //     } else if (isset($params['value']) && !isset($params['column'])) {
    //         $statement = "
    //             SELECT * 
    //             FROM book
    //             WHERE ";
    //         for ($i = 0; $i < count($this->allowedParams) - 1; $i++) {
    //             $statement = $statement . $this->allowedParams[$i] . " LIKE '%" . $params['value'] . "%' OR ";
    //         }
    //         $statement = $statement . $this->allowedParams[$i] . " LIKE '%" . $params['value'] . "%';";
    //         return $this->executeQuery($statement);
    //     } else {
    //         print_r("Invalid API or Request Method");
    //         header("HTTP/1.1 404 Not Found");
    //         exit();
    //     }
    // }

    private function executeQuery($statement)
    {
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    // public function getBookWithSpecificColumns($book_id, $columns)
    // {
    //     $statement = "
    //     SELECT " . $columns . " 
    //     FROM book
    //     WHERE book_id=:book_id;
    // ";

    //     try {
    //         $statement = $this->db->prepare($statement);
    //         $statement->execute(array(
    //             'book_id' => $book_id
    //         ));
    //         $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    //         return $result;
    //     } catch (\PDOException $e) {
    //         exit($e->getMessage());
    //     }
    // }

    public function update($user_id, $input)
    {
        $statement = "
        UPDATE user 
        SET isbn =:isbn, title=:title, author_name=:author_name, pub_year=:pub_year,
        total_count=:total_count,current_count=:current_count,publisher=:publisher,
        category_id=:category_id,updated_at=now()
        WHERE user_id=:user_id;
      ";

        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'isbn' => $input['isbn'],
                'title' => $input['title'],
                'author_name' => $input['author_name'],
                'pub_year' => $input['pub_year'],
                'total_count' => $input['total_count'],
                'current_count' => $input['current_count'],
                'publisher' => $input['publisher'],
                'category_id' => $input['category_id'],
                'book_id' => $book_id
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

    public function delete($book_id)
    {

        $statement = "
        DELETE FROM book WHERE book_id=:book_id;
    ";
        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'book_id' => $book_id,
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