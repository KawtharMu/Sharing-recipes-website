<?php

session_start();

include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();

if(!isset($_SESSION["user_email"])){
  header("Location: login.php");
  exit;
} 

//insert reocrd
if (isset($_POST['insert_ingredient'])) {
  $name = $_POST['name'];
  $user_id = $_SESSION["user_id"];
  // $service="";
  // foreach($_POST['service'] as $i) {
  //     $service.=$i.', ';
  // }

      // Insert Query
      $query1="insert into ingredients set name=?,user_id=?";
      $stmt1 = $db->prepare($query1);
      
      if ($stmt1) {
          $stmt1->bind_param('ss', $name, $user_id);
          $stmt1->execute();
          
          if ($stmt1->affected_rows == 1) {
            
            $_SESSION['message']= "Ingredient added successfully";
            $_SESSION['msg_type']= "success";
              // echo "Insert succesfully";
          } else {
            $_SESSION['message']= "Something went wrong";
            $_SESSION['msg_type']= "danger";
              // echo "Not Insert";
          }


          $stmt1->close(); 



          header("location: ingredient_list.php");
      }
}


?>