<?php

class Category
{
    protected $db;

    protected $required = ['category_id', 'category_name'];

    protected $allowedParams = [
        'category_id', 'category_name',
        'category_count', 'created_at', 'updated_at'
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
        INSERT INTO category 
            (category_id, category_name, category_count, created_at, updated_at)
        VALUES
            (:category_id, :category_name, :category_count, now(),now());
    ";

        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'category_id' => $input['category_id'],
                'category_name' => $input['category_name'],
                'category_count' => $input['category_count'],
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

    public function getCategory($category_id)
    {
        $statement = "
        SELECT * 
        FROM category
        WHERE category_id=:category_id
    ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'category_id' => $category_id,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function getCategorys()
    {
        $statement = "
        SELECT * 
        FROM category
    ";
    // print_r($statement);

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    // public function getCategoryWithParams($params)
    // {
    //     if (isset($params['sort']) && isset($params['column'])) {
    //         $statement = "
    //         SELECT * 
    //         FROM category ORDER BY " . $params['column'];
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
    //         FROM category limit " . $params['limit'];
    //         if (isset($params['offset'])) $statement = $statement . " offset " . $params['offset'];
    //         return $this->executeQuery($statement);
    //     } else if (isset($params['column']) && isset($params['value']) && in_array($params['column'], $this->allowedParams)) {
    //         $statement = "
    //             SELECT * 
    //             FROM category
    //             WHERE " . $params['column'];
    //         if (isset($params['like']))
    //             $statement = $statement . " LIKE '%" . $params['value'] . "%';";
    //         else $statement = $statement . "=" . $params['value'] . ";";
    //         return $this->executeQuery($statement);
    //     } else if (isset($params['value']) && !isset($params['column'])) {
    //         $statement = "
    //             SELECT * 
    //             FROM category
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


    // public function getCategoryWithSpecificColumns($category_id, $columns)
    // {
    //     $statement = "
    //     SELECT " . $columns . " 
    //     FROM category
    //     WHERE category_id=:category_id;
    // ";

    //     try {
    //         $statement = $this->db->prepare($statement);
    //         $statement->execute(array(
    //             'category_id' => $category_id
    //         ));
    //         $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    //         return $result;
    //     } catch (\PDOException $e) {
    //         exit($e->getMessage());
    //     }
    // }


    public function update($category_id, $input)
    {
        $statement = "
        UPDATE category
        SET category_name =:category_name,
        updated_at=now()
        WHERE category_id=:category_id;
      ";
        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'category_name' => $input['category_name'],
                'category_id' => $category_id,
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


    public function delete($category_id)
    {

        $statement = "
        DELETE FROM category WHERE category_id=:category_id;
    ";
        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'category_id' => $category_id,
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
