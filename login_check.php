<?php

session_start();

include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();

  if(isset($_POST['login_form'])) {

    $flag = false;
    $user_email = $_POST['user_email'];
    $password = md5($_POST['password']);
    $user_status = 1;
  
    // Insert Query
    $query1="select * from users where email=? and password=? and status=? ";
    $stmt1 = $db->prepare($query1);
    
    if ($stmt1) {
      $stmt1->bind_param('ssi', $user_email, $password, $user_status);
      $stmt1->execute();
      
      $result = $stmt1->get_result();
  
      if($result->num_rows == 1){
  
        $row = $result->fetch_array(MYSQLI_ASSOC);


        $_SESSION['user_id']= $row['id'];
        $_SESSION['user_name']= $row['name'];
        $_SESSION['user_email']= $row['email'];

        if ($_POST['remember_me']=="1") {
          setcookie("user_email", $_POST['user_email'], time() + 60*60*24*7);
        }
        
        // $_SESSION['message']= "Login Successfully";
        // $_SESSION['msg_type']= "success";
        header("location: index.php");
  
        $stmt1->close(); 
  
      } else {
        $_SESSION['message']= "Email or password incorrect or your email is not verified";
        $_SESSION['msg_type']= "danger";
        header("location: login.php");
      }
  
    }
  }
?>