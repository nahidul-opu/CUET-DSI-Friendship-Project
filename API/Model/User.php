<?php
//  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
class User
{
    protected $db;

    protected $required = [
        'email', 'name','contact_no', 'image_path',
    ];
    protected $allowedParams = [
        'email', 'name', 'borrow_count','contact_no', 'image_path',
        'fine', 'updated_at'
    ];
    function __construct($dbConnnector)
    {
        $this->db = $dbConnnector;
    }

    function hasRequiredField($input)
    {
        foreach ($this->required as $item) {
            {
                // print_r($input[$item]);
            if (empty($input[$item])) {
                print_r($item);
                return false;
            }
        }}
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
                'email' => $input['email'],
                'name' => $input['name'],
                'borrow_count' => $input['borrow_count'],
                'contact_no' => $input['contact_no'],
                'image_path' => $input['image_path'],
                'fine' => $input['fine'],
                // 'category_id' => $input['category_id'],
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

    public function update($user_id, $input)
    {
        $statement = "
        UPDATE user 
        SET email =:email, name=:name, borrow_count=:borrow_count, contact_no=:contact_no,
        image_path=:image_path,fine=:fine,updated_at=now()
        WHERE user_id=:user_id;
      ";

        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'email' => $input['email'],
                'name' => $input['name'],
                'borrow_count' => $input['borrow_count'],
                'contact_no' => $input['contact_no'],
                'image_path' => $input['image_path'],
                'fine' => $input['fine'],
                'user_id' => $user_id
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

    public function delete($user_id)
    {

        $statement = "
        DELETE FROM user WHERE user_id=:user_id;
    ";
        try {
            $statement = $this->db->prepare($statement);
            $result = $statement->execute(array(
                'user_id' => $user_id,
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