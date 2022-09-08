<?php

session_start();

include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();

if(isset($_SESSION["user_email"])){
  header("Location: index.php");
  exit;
} 

//insert reocrd
if (isset($_POST['verify_email'])) {
  $flag = false;
  $registration_key = $_POST['registration_key'];

  // Insert Query
  $query1="select * from users where registration_key=?";
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
    $stmt1->bind_param('s', $registration_key);
    $stmt1->execute();
    
    $result = $stmt1->get_result();

    if($result->num_rows == 1){

      $status = 1;
      $query2 = "UPDATE users SET status=? WHERE registration_key=?";
      $stmt2 = $db->prepare($query2);
      
      if ($stmt2) {
        $stmt2->bind_param('is', $status, $registration_key);
        $stmt2->execute();
        
        if ($stmt2->affected_rows == 1) {
          $stmt2->close(); 
          $flag = true;
        }
      }

      $stmt1->close(); 

    } else {
      $_SESSION['message']= "Invalid Registration Key";
      $_SESSION['msg_type']= "danger";
      header("location: verify_email.php");
    }


    if ($flag) {
      $_SESSION['message']= "Registration successfull";
      $_SESSION['msg_type']= "success";
      header("location: login.php");
    } else {
      $_SESSION['message']= "Something went wrong";
      $_SESSION['msg_type']= "danger";
      header("location: verify_email.php");

    }
  }
}


?>