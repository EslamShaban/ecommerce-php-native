<?php


/*
** Get All Function v1.0
** Function To Get Any Table From Database
*/

function getAllFrom($field, $table, $where=NULL, $and, $orderfield, $ordering = 'ASC'){

    global $con;
    
    $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
    
    $getAll->execute();
    
    $all = $getAll->fetchAll();
    
    return $all;
    
}







/*
** Get Records Function v1.0
** Function To Get Categories From Database
*/

function getCat(){

    global $con;
    
    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID DESC");
    
    $getCat->execute();
    
    $cats = $getCat->fetchAll();
    
    return $cats;
    
}








   function getTitle(){
       
       global $pageTitle;
       
       if(isset($pageTitle)){
           echo $pageTitle;
       }else{
           echo 'Default';
       }
       
   }



/* 
** Home Redirect Function v2.0
** This Function Accept Parameters
** $theMsg = Echo The Message [Error | Success | Warning]
** $url = The Link You Want To Redirect To
** $seconds = Seconds Before Redirecting
*/

function redirectHome($theMsg, $url = null, $seconds = 3){
    
    if($url === null){
        $url  = "index.php";
        $link = "HomePage";
    }else{
        
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){
            $url  = $_SERVER['HTTP_REFERER'];
            $link = "Previous Page";
        }else{
            $url  = "index.php";
            $link = "HomePage";

        }
    }
    
    echo $theMsg ;
    
    echo '<div class="alert alert-info"> You Will Be Redirected To ' . $link . ' After ' . $seconds . ' Seconds</div>';
    
    header("refresh:$seconds; url=$url");
    exit();
    
}

/*
** Check Items Function
** Function To Check Item In Database [Function Accept Parameters]
** $select = The Item TO Select [Example : user, Item, Category]
** $from = The Table To Select From [Example : users, Items, Categories] 
** $value = The Value Fo Select [Example : Osama, Box, Electronics]
*/

function checkItem($select, $from, $value){
    
    global $con;
    
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select=?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    return $count;
}

/*
** This Function Combine (checkItem, CountItems)
**function NumbersOfUsers($select, $from, $value = null){
**  
**  global $con;
**    
**  $query = '';
**    
**  if($value !== null){
**        $query = 'WHERE ' . $select . '= ?';
**  }
**    
**  $stmt = $con->prepare("SELECT $select FROM $from $query");
**  $stmt->execute(array($value));
**  $count = $stmt->rowCount();
**  return $count;
**}

*/

/*
** Count Number Of Items Function v1.0
** Function To Count Number Of Items Rows
** $item = The Item TO Count
** $table = The Table To Choose From
*/

function CountItems($item, $table){
    
    global $con;
              
    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");   
    $stmt2->execute();
           
    return $stmt2->fetchColumn();
    
}

/*
** Get Latest Records Function v1.0
** Function To Get Latest Items From Database [Users | Items | Comments]
** $select = Field To Select
** $table = The Table To Choose From
** $order = The Desc Ordering
** $limit = Number Of Records To Get
*/

function getLatest($select, $table, $where = NULL , $order, $limit = 5){

    if($where == NULL){
      $where = "";
    }
    
    global $con;
    
    $stmt = $con->prepare("SELECT $select FROM $table $where ORDER BY $order DESC LIMIT $limit ");
    
    $stmt->execute();
    
    $rows = $stmt->fetchAll();
    
    return $rows;
    
}
