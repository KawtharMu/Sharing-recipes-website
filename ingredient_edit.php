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

    $query1="select * from ingredients where id=?";
    // $query1="select  r.id, r.name, r.description, r.ingredients, r.created_at, u.name as user_name  from recipes  as r JOIN users as u ON r.user_id = u.id where r.id=? order by r.id desc";

    $stmt1 = $db->prepare($query1);
    
    if ($stmt1) {
        $stmt1->bind_param('i', $id);
        $stmt1->execute(); 

        $result = $stmt1->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $id = $row["id"];
            $name = $row["name"];
            
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
            <span class="title">Edit Recipe</span>
            <form  id="form1" method="post" action=ingredient_update.php class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

                <input type="hidden" name="id" value="<?php echo $id; ?>" /><!-- hidden id input -->

                <div class="form-group mb-3">
                <label >Name</label>
                <input type="text" name="name" value="<?php echo $name  ?>" class="form-control" placeholder="Enter Recipe Name" required />
              </div>
            
              <div class="input-field button">
                <input type="submit" name="update_ingredient" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  
  
</script>
    <?php require_once("parts/footer.php");?>  

