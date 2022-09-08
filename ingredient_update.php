  
<?php

session_start();

include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();

if(!isset($_SESSION["user_email"])){
  header("Location: login.php");
  exit;
} 


//update record
if(isset($_POST['update_ingredient'])){

  $id=$_POST['id'];

  $name = $_POST['name'];

  // Insert Query
  $query1 = "UPDATE ingredients SET name=? WHERE id=?";
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
      $stmt1->bind_param('si', $name, $id);
      $stmt1->execute();
      
      if ($stmt1->affected_rows == 1) {
        
     
        $_SESSION['message']= "Ingredient updated successfully";
        $_SESSION['msg_type']= "success";
      } else {
        $_SESSION['message']= "Something went wrong";
        $_SESSION['msg_type']= "danger";
      }


      $stmt1->close(); 


      header("location: ingredient_list.php");
      
  }else{
      //oops something went wrong
  }
}


?>