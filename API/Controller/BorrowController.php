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
                if(count($this->queryParams)>0){
               if (isset($this->queryParams['book_id']) && isset( $this->queryParams['user_id']) && count($this->queryParams) === 2)   {$this->readBorrows();}
               if (isset($this->queryParams['user_id']) && count($this->queryParams) === 1)   {$this->readBorrowUser();}
               if (isset($this->queryParams['book_id']) && count($this->queryParams) === 1)   {$this->readBorrowbyBook();}
                }
                else   $this->readBorrow();
            }
        else if($this->requestMethod=='DELETE'){
            $this->delete();
        }
    }

 public function readBorrow(){
    $result= $this->borrow -> read();
    if($result){
    echo json_encode($result);
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

}