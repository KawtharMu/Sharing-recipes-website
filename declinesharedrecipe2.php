<?php 
include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();
session_start();

if(isset($_GET['id'])){

  $id=$_GET['id'];
  // $status=1;

  $query1 = "DELETE FROM share_recipes  WHERE id=?";
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
      $stmt1->bind_param('i', $id);
      $stmt1->execute();
      $output='';
      if ($stmt1->affected_rows == 1) {
         $_SESSION['message']= "Shared Recipe Decline successfully";
      $_SESSION['msg_type']= "success";

      header("location: sharedreciepeslist.php");
       
      } else {
        $_SESSION['message']= "Something Went Wrong...";
      $_SESSION['msg_type']= "danger";

      header("location: sharedreciepeslist.php");
      }

      $stmt1->close(); 


      
  }else{
      //oops something went wrong
  }
}
 ?>