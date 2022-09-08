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
if (isset($_POST['name'])) {
  $name = $_POST['name'];
  $user_id = $_SESSION["user_id"];
  // $service="";
      $query1="insert into ingredients set name=?,user_id=?";
      $stmt1 = $db->prepare($query1);
      
      if ($stmt1) {
          $stmt1->bind_param('si', $name, $user_id);
          $stmt1->execute();
          $output='';
          if ($stmt1->affected_rows == 1) {
              $query = "SELECT * from ingredients";
                
                $stmt1 = $db->prepare($query);
                
                if($stmt1)
                {
                      $stmt1->execute(); 
                      $result = $stmt1->get_result();

                    while($r=$result->fetch_array(MYSQLI_ASSOC))
                    {

            $output.='<input class="form-check-input" type="checkbox" name="ingredients[]" value="'.$r['id'].'" id="flexCheckDefault">
                  <label class="form-check-label" id="label" for="flexCheckDefault">
                    '.$r['name'].'   </label>';
           
          }  } else {
            $_SESSION['message']= "Something went wrong";
            $_SESSION['msg_type']= "danger";
              // echo "Not Insert";
          }


          $stmt1->close(); 

          echo $output;

          // header("location: ingredient_list.php");
      }
}
}


?>