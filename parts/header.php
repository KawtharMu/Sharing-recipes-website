<?php
session_start();
error_reporting(0);
require_once("users.php");
?>

<!-- // it was require_once -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- ===== Iconscout CSS =====-->
    <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"
    />

    <!-- === CSS === -->
    <link rel="stylesheet" href="./css/mainStyleCss.css" />
    <link rel="stylesheet" href="./css/chosen.css" />
    <link rel="stylesheet" href="./css/datatables.min.css" />

    <!-- Browser tab icon -->
    <link rel="icon" href="./images/whisk.png" />

    <title>Login</title>

    <style>
      .user_style {
        display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    border: 1px solid #bdbdbd;
    border-radius: 44px;
    margin: 0px 5px 0px 5px;
      }
    </style>
  </head>
  <body>
    <!-- header starts here-->
    <header>
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="./index.php">FoodMakers</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"
              ><i class="uil uil-bars"></i
            ></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
              <!-- <li class="nav-item">
                <a class="nav-link" href="ingredient_list.php">Ingredients</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="recipe_list.php">Recipes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="recipe_create.php">Create Recipe</a>
              </li>
             <!--  <li class="nav-item">
                <a class="nav-link" href="ingredient_create.php">Create Ingredients</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="recipe_invitations.php">Invitations</a>
              </li>
            </ul>
            <form class="d-flex">

            <?PHP if (!isset($_SESSION['user_id'])) { ?>
              <button
                class="btn0"
                type="button"
                onclick="location.href='register.php'"
              >
                Register
              </button>
              <button
                class="btn1 mx-3"
                type="button"
                onclick="location.href='login.php'"
              >
                Login
              </button>

              <?PHP } else { ?>
                  <p class="user_style"><i class="uil uil-user"></i>Hey <?PHP echo $_SESSION['user_name'] ?></p>
                  <div class="dropdown">
                    <div class="userdrop">
                      <button type="button" class="btnuser" onclick="location.href='logout.php'">Logout   <i class="uil uil-arrow-from-right"></i></button>
                    </div>
                </div>
                    
              <?PHP }?>
              
            </form>
          </div>
        </div>
      </nav>
    </header>
    <!-- header ends here -->
<!-- A Bootstrap Modal -->
<?php 
  include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();
$status='0';
     $query1="SELECT s.*,u.name,r.name as recipe from share_recipes s LEFT JOIN users u ON u.id=s.recipe_owner_id LEFT JOIN recipes r ON r.id=s.recipe_id  where s.user_id=? AND s.status=?";
// echo $query1;exit;

     
    $stmt1 = $db->prepare($query1);
    
    if ($stmt1) {
        $stmt1->bind_param('ss', $_SESSION['user_id'],$status);

        // var_dump($stmt1);exit;
        $stmt1->execute(); 

        $result = $stmt1->get_result();
          $r = $result->fetch_array(MYSQLI_ASSOC);
          // var_dump();exit;
        if($result->num_rows > 0){
            
        
 ?>
<div id="custom-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $r['name'].' Has sent you an invitation of '.$r['recipe'].' recipe'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <button type="button"  id="accept" class="btn btn-success" data-id="<?php echo $r['id'] ?>">Accept</button>
        <button type="button" id="decline" class="btn btn-danger"  data-id="<?php echo $r['id'] ?>">Decline</button>
       
      </div>
    <!--   <div class="modal-footer">
        
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<?php } } ?>
 <script src="./JScripts/jquery.min.js"></script>
    <script>
$(document).ready(function(){
  /* ----- JavaScript ----- */
$(function () {
  $("#custom-modal").modal("show");
});

  $('#accept').on('click',function(){
    var id=$(this).data('id');
    // alert(id);
    $.ajax({
      url: './acceptinvitation.php',
      type: 'POST',
      data: {id: id},
      success:function(result){
        // alert(result);
        if(result=='true')
        {
          alert('Invitation Accepted...');
          location.reload();
        }
      }
    })  
  })
    $('#decline').on('click',function(){
    var id=$(this).data('id');
    // alert(id);
    $.ajax({
      url: './deleteinvitation.php',
      type: 'POST',
      data: {id: id},
      success:function(result){
        // alert(result);
        if(result=='true')
        {
          alert('Invitation Decline...');
          location.reload();
        }
      }
    })  
  })

})
</script>