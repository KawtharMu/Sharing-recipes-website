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
  // if(!isset($_SESSION["user_email"])){
  //   header("Location: login.php");
  //   exit;
  // }
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
          <!-- Registration Form-->
          <div class="form login">
            <span class="title">Create Ingredient</span>
            <form  id="form1" method="post" action=ingredient_store.php class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

              <div class="form-group mb-3">
                <label >Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Recipe Name" required />
              </div>
              <div class="input-field button">
                <input type="submit" name="insert_ingredient" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  
</script>
    <?php require_once("parts/footer.php");?>  

