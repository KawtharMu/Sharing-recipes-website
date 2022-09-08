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
if(isset($_GET['id'])){

  $recipe_id=$_GET['id'];
  $user_id=$_SESSION['user_id'];

  //remove record from database
  $query1="delete from share_recipes where recipe_owner_id=? AND recipe_id=?";
  
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
      $stmt1->bind_param('ii', $user_id,$recipe_id);
      
      $stmt1->execute(); 

      $stmt1->close(); 

      $_SESSION['message']= "Shared Recipe deleted successfully";
      $_SESSION['msg_type']= "danger";

      header("location: sharedreciepeslist.php");

  }else{
      //oops something went wrong
  }
}

?>