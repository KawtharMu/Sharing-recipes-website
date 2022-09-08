  
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
if(isset($_POST['update_recipe'])){

  $id=$_POST['id'];

  $name = $_POST['name'];
  $details = $_POST['details'];
  // $ingredients = $_POST['ingredients'];
  $description = '';
  foreach($_POST['description'] as $i) {
    if ($i != ''){
      $description.=$i.',';
    }
  }
 $ingred="";
  foreach($_POST['ingredients'] as $i) {
      $ingred.=$i.',';
  }
  // Insert Query
   $query1="insert into recipes set name=?,image=?,description=?,ingredients=?,details=?,user_id=?";
  $query1 = "UPDATE recipes SET name=?, description=?,ingredients=?,details=? WHERE id=?";
  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
      $stmt1->bind_param('ssssi', $name, $description,$ingred,$details, $id);
      $stmt1->execute();
      
      if ($stmt1->affected_rows == 1 || $stmt1->affected_rows == 0) {
        
          
        $_SESSION['message']= "Recipe updated successfully";
        $_SESSION['msg_type']= "success";
      } else {
        $_SESSION['message']= "Something went wrong";
        $_SESSION['msg_type']= "danger";
      }


      $stmt1->close(); 


      header("location: recipe_list.php");
      
  }else{
      //oops something went wrong
  }
}


?>