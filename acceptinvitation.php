<?php 
include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();


if(isset($_POST['id'])){

  $id=$_POST['id'];
  $status=1;

  $query1 = "UPDATE share_recipes SET status=? WHERE id=?";
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
      $stmt1->bind_param('si', $status, $id);
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