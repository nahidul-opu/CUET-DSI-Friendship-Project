<?php
if (!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/Model/Borrow.php');
class BorrowController{

    private $db = null;
    private $requestMethod;
    private $borrow;
    function __construct($dbConnector,$method)
    {
        $this->db = $dbConnector;
        $this->requestMethod = $method;
        $this->borrow = new Borrow($this->db);
    }
    function selectMethod(){
           if($this->requestMethod=='GET'){
               $this->readBorrow();
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
}

?>