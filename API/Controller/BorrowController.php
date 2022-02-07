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
               if ($this->queryParams['book_id'] && count($this->queryParams) === 2)   {$this->readBorrows();}
                }
                else   $this->readBorrow();
            }
        else if($this->requestMethod=='DELETE'){
            $this->delete();
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


     $this->borrow->readSpec();
    // create array
    $br_arr = array(
        "book_id" =>  $this->borrow->book_id,
        "user_id" =>  $this->borrow->user_id,
        "issue_date" =>  $this->borrow->issue_date,
        "due_date" =>  $this->borrow->due_date,
        "created_at" =>  $this->borrow->created_at,
        "updated_at" =>  $this->borrow->updated_at,
    );
  
    echo json_encode($br_arr);
}
}

?>