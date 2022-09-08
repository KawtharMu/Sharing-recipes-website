<?php

// include 'connect_db.php';
// $database=new database();
// $db = $database->connect_mysqli();
?>



<?php require_once("parts/header.php");?>

<?php
  if(!isset($_SESSION["user_email"])){
    header("Location: login.php");
    exit;
  } 
?>  

<?php

$id="";
$name="";
$description="";
$ingredients="";
$user_name="";
$created_at="";

if(isset($_GET['id'])){
    $id=$_GET['id'];

    
  $query21="select * from recipes where id=? and user_id=?";

  $stmt21 = $db->prepare($query21);
  
  if ($stmt21) {
    $stmt21->bind_param('is', $_GET['id'], $_SESSION['user_id']);
    $stmt21->execute(); 

    $result21 = $stmt21->get_result();

    if($result21->num_rows < 1){
      
      $query221="select * from share_recipes where recipe_id=? and status=? and user_id=?";
      $stmt221 = $db->prepare($query221);
      
      if ($stmt221) {
        $share_status = '1';
        $stmt221->bind_param('ssi', $_GET['id'], $share_status, $_SESSION['user_id']);
        $stmt221->execute(); 

        $result221 = $stmt221->get_result();

        if($result221->num_rows < 1){
          // $_SESSION['message']= "Email already exists.";
          // $_SESSION['msg_type']= "danger";
          header("Location: recipe_list.php");
          exit;
        }
      }
    }
  }

    $query1="select  r.id, r.name, r.description, r.ingredients,r.image, r.created_at, u.name as user_name  from recipes  as r JOIN users as u ON r.user_id = u.id
where r.id=? order by r.id desc";

    $stmt1 = $db->prepare($query1);
    
    if ($stmt1) {
        $stmt1->bind_param('i', $id);
        $stmt1->execute(); 

        $result = $stmt1->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $name = $row["name"];
            $description = explode(',',$row["description"]);
            $ingredients = $row["ingredients"];
            $image       = $row["image"];
            $user_name   = $row["user_name"];
            $created_at  = $row["created_at"];

            
        } else{
            // URL doesn't contain valid id. Redirect to error page
            // exit();
        }

        $stmt1->close(); 
    }else{
        //oops something went wrong
    }
}


?>

    
<style>
  #recipe_create_container {
    margin-top: 50px;
    width: 100%;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 10px rgb(0 0 0 / 10%);
    /* height: 650px; */
}
.main input {
    height: 60px;
    width: 100%;
    border: 1px solid #b5b4b4;
    outline: none;
    padding: 10px;
    border-radius: 6px;
}
</style>

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="recipe_create_container">
        <div class="forms">
          <div class="form login">
            <span class="title">View Recipe</span>
            <form  id="form1" class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

              <div class="form-group mb-3">
                <label >Name</label>
                <input type="text" name="name" value="<?php echo $name  ?>" class="form-control" placeholder="Enter Recipe Name" disabled />
              </div>
              <div class="form-group mb-3">
                <div class="row">
                  <div class="col-md-4">
                    <label for="">Image</label><br>
                    <img src="imgs/<?php echo $image  ?>" class="img-responsive" style="width: 400px;height: 250px" alt="">
                  </div>
                </div>
              </div>
              <div class="form-group mb-3">
                <label >Ingredients</label>
                <input type="text" name="ingredients"  value="<?php echo $ingredients  ?>" class="form-control" placeholder="Enter Recipe Ingredients" disabled />
              </div>
              <div class="form-group mb-3">
                <label >Instructions</label>
                <div class="table rowfy">
                  <div class="tbody">
                    <?php foreach($description as $key => $descp) { ?>
                      <?php if( count($description) != $key + 1 ) { ?>
                      <div class="row tr-row mt-2">
                          <div class="col-10 pr-0">
                            <input type="checkbox" name="description[]" value="<?php echo ($descp)  ?>" style="height: 18px;width: 2%;"/>
                            <?php echo ($descp)  ?>
                          </div>
                      </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div> 
              </div>
              <div class="form-group mb-3">
                <label >Owner Name</label>
                <input type="text" name="user_name"  value="<?php echo $user_name  ?>" class="form-control" disabled />
              </div>
              <div class="form-group mb-3">
                <label >Published At</label>
                <input type="text" name="created_at"  value="<?php echo (date_format(new DateTime($created_at), 'd M, Y'))  ?>" class="form-control" placeholder="Enter Recipe Ingredients" disabled />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  
  
<?php require_once("parts/footer.php");?>  
