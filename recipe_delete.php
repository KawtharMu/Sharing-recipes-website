<?php

session_start();

include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();

if(!isset($_SESSION["user_email"])){
  header("Location: login.php");
  exit;
} 

// delete record
if(isset($_GET['delete_id'])){

  $id=$_GET['delete_id'];

  //remove record from database
  $query1="delete from recipes where id=?";
  
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
      $stmt1->bind_param('i', $id);
      
      $stmt1->execute(); 

      $stmt1->close(); 

      $_SESSION['message']= "Recipe deleted successfully";
      $_SESSION['msg_type']= "danger";

      header("location: recipe_list.php");

  }else{
      //oops something went wrong
  }
}

?>