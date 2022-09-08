<?php 
include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();


if(isset($_POST['id'])){

  $id=$_POST['id'];
  // $status=1;

  $query1 = "DELETE FROM share_recipes  WHERE id=?";
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
      $stmt1->bind_param('i', $id);
      $stmt1->execute();
      $output='';
      if ($stmt1->affected_rows == 1) {
        $output='true';
       
      } else {
       $output='false';
      }

      echo $output;
      $stmt1->close(); 


      
  }else{
      //oops something went wrong
  }
}
 ?>