<?php
if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Borrow.php');
class BorrowController{

    private $db = null;
    private $requestMethod;
    private $queryParams;
    private $borrow;
    function __construct($dbConnector,$method,$queryString)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        parse_str($queryString, $this->queryParams);
        $this->borrow = new Borrow($this->db);
    }
    function selectMethod(){
           if($this->requestMethod=='GET'){
                //if(count($this->queryParams)>0){
               //if (isset($this->queryParams['book_id']) && isset( $this->queryParams['user_id']) && count($this->queryParams) === 2)   {$this->readBorrows();}
               //if (isset($this->queryParams['user_id']) && count($this->queryParams) === 1)   {$this->readBorrowUser();}
               //if (isset($this->queryParams['book_id']) && count($this->queryParams) === 1)   {$this->readBorrowbyBook();}
                //}
                $this->readBorrow();
            }
        else if($this->requestMethod=='DELETE'){
            $this->delete();
        }
        else if($this->requestMethod=='POST'){
            $this->createBorrow();
        }
        else if($this->requestMethod=='PUT'){
            if ($this->queryParams['book_id']) $response = $this->updateBorrow($this->queryParams['book_id']);
            else ($this->raiseException());
        }
        
    }

 public function readBorrow(){
    $result= $this->borrow -> read();
    $num= $result->rowCount();
    if($num>0){
    $borrow_arr = array();
    $borrow_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $borrow_item = array(
            'book_id'=>$book_id,
            'user_id'=>$user_id,
            'issue_date'=>$issue_date,
            'due_date'=>$due_date,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at,
        );

        array_push($borrow_arr['data'],$borrow_item);
    }
    echo json_encode($borrow_arr);
    }
    else{
        echo json_encode(
            array('message'=>'No book issue history found')
        );

}
 }
 public function delete(){
     $this->borrow->book_id=$this->queryParams['book_id'];
     $this->borrow->user_id=$this->queryParams['user_id'];
     if($this->borrow->delete()){
        echo json_encode(array("message" => "Product was deleted."));
    }
    else{
        echo json_encode(array("message" => "Unable to delete product."));
    }
 }
 
public function readBorrows(){
    $this->borrow->book_id=$this->queryParams['book_id'];
     $this->borrow->user_id=$this->queryParams['user_id'];
     $result=$this->borrow->readSpec();
     $num= $result->rowCount();
     if($num>0){
     $bor_arr = array();
     $bor_arr['data'] = array();
 
     while($row = $result->fetch(PDO::FETCH_ASSOC)){
         extract($row);
 
         $bor_item = array(
             'book_id'=>$book_id,
             'user_id'=>$user_id,
             'issue_date'=>$issue_date,
             'due_date'=>$due_date,
             'created_at'=>$created_at,
             'updated_at'=>$updated_at,
         );
 
         array_push($bor_arr['data'],$bor_item);
     }
     echo json_encode($bor_arr);
     }
     else{
         echo json_encode(
             array('message'=>'No book issue history found')
         );
}
}
public function readBorrowUser(){
     $this->borrow->user_id=$this->queryParams['user_id'];
     $result=$this->borrow->readbyUser();
     $num= $result->rowCount();
     if($num>0){
     $bor_arr = array();
     $bor_arr['data'] = array();
 
     while($row = $result->fetch(PDO::FETCH_ASSOC)){
         extract($row);
 
         $bor_item = array(
             'book_id'=>$book_id,
             'user_id'=>$user_id,
             'issue_date'=>$issue_date,
             'due_date'=>$due_date,
             'created_at'=>$created_at,
             'updated_at'=>$updated_at,
         );
 
         array_push($bor_arr['data'],$bor_item);
     }
     echo json_encode($bor_arr);
     }
     else{
         echo json_encode(
             array('message'=>'No book issue history found')
         );
}
}
public function readBorrowbyBook(){
    $this->borrow->book_id=$this->queryParams['book_id'];
    $result=$this->borrow->readbyBookID();
    $num= $result->rowCount();
    if($num>0){
    $bor_arr = array();
    $bor_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $bor_item = array(
            'book_id'=>$book_id,
            'user_id'=>$user_id,
            'issue_date'=>$issue_date,
            'due_date'=>$due_date,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at,
        );

        array_push($bor_arr['data'],$bor_item);
    }
    echo json_encode($bor_arr);
    }
    else{
        echo json_encode(
            array('message'=>'No book issue history found')
        );
}
}
public function createBorrow()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->borrow->create($input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 409', 'Duplicate Data', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Inserted 1 Row');
    }
public function updateBorrow($book_id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input)) {
            $input = (array) $_POST;
        }
        $validation = $this->validateInput($input);
        if (!$validation['isValid']) {
            return $validation;
        }
        $response = $this->borrow->update($book_id,$input);
        if (!$response['success']) return $this->Responce('HTTP/1.1 500', 'Internel Server Error', $response['error']);
        else return $this->Responce('HTTP/1.1 200', 'OK', 'Updated 1 Row');
    }
    public function validateInput($input)
    {
        print_r($input)
        $hasRequired = $this->create->hasRequiredField($input);
        if (!$hasRequired) {
            return $this->Responce('HTTP/1.1 422', 'Unprocessable Request', 'Missing Field(s)', 'isValid', false);
        }
        return $this->Responce('HTTP/1.1 200', 'OK', 'Valid', 'isValid', true);
    }
    public function Responce($headerCode, $headerMsg, $bodyMsg, $customKey = null, $customValue = null)
    {
        $response['status_code_header'] = $headerCode . ' ' . $headerMsg;
        if ($customKey)
            $response[$customKey] = $customValue;
        $response['body'] = json_encode([
            'message' => $bodyMsg
        ]);
        return $response;
    }
    function raiseException()
    {
        print_r("Invalid API or Request Method");
        header("HTTP/1.1 404 Not Found");
        exit();
    }


}

?>