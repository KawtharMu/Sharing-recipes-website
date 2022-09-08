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
if (isset($_POST['insert_recipe'])) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $details = $_POST['details'];
  $user_id = $_SESSION["user_id"];
   $image=$_FILES['image']['name'];
   $path='imgs/';
  $img= $path . basename($image);
  move_uploaded_file($_FILES['image']['tmp_name'], $img);
   $ingred="";
  foreach($_POST['ingredients'] as $i) {
      $ingred.=$i.',';
  }
  
  $description = '';
  foreach($_POST['description'] as $i) {
      $description.=$i.',';
  }
  // $service="";
  // foreach($_POST['service'] as $i) {
  //     $service.=$i.', ';
  // }


      // Insert Query
      $query1="insert into recipes set name=?,image=?,description=?,ingredients=?,details=?,user_id=?";
      $stmt1 = $db->prepare($query1);
      
      if ($stmt1) {
          $stmt1->bind_param('ssssss', $name,$image, $description,$ingred,$details, $user_id);
          $stmt1->execute();
           // $lastId=mysqli_stmt_insert_id($stmt1);
          if ($stmt1->affected_rows == 1) {
            $_SESSION['message']= "Recipe added successfully";
            $_SESSION['msg_type']= "success";
              // echo "Insert succesfully";
          } else {
            $_SESSION['message']= "Something went wrong";
            $_SESSION['msg_type']= "danger";
              // echo "Not Insert";
          }


          $stmt1->close(); 



          header("location: recipe_list.php");
      }
}


?>