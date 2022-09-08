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


if(isset($_POST['share_recipe'])){
    $recipe_owner_id=$_SESSION['user_id'];
    $recipe_id=$_POST['recipe_id'];
    $user_id=$_POST['user_id'];
    $status= 0;

      // Insert Query
      $query1="insert into share_recipes set recipe_owner_id=?,recipe_id=?,user_id=?,status=?";
      $stmt1 = $db->prepare($query1);
      
      if ($stmt1) {
        $stmt1->bind_param('iiis', $recipe_owner_id, $recipe_id, $user_id, $status);
        $stmt1->execute();
        
        if ($stmt1->affected_rows == 1) {
          
          $_SESSION['message']= "Recipe shared successfully";
          $_SESSION['msg_type']= "success";
            // echo "Insert succesfully";
        } else {
          $_SESSION['message']= "Something went wrong";
          $_SESSION['msg_type']= "danger";
            // echo "Not Insert";
        }

        $stmt1->close(); 

        header("location: recipe_list.php");
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
    
    #user_name_dataPar
    {
        position: relative !important;
    }
    
    #user_name_data
    {
      position: absolute !important;
    width: 100% !important;
    z-index: 100 !important;
    }
    #user_name_data li:hover
    {
        background-color: #dbe9ff;
    }

    
    .table_col{ 
        width: 31%;
        margin: auto;
        }
        
    .name_col{ width: 50%;}
    .name2_col{ 
        width: 20%;
    }

    </style>

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="recipe_create_container">
        <div class="forms">
          <div class="form login">
            <span class="title">Share Recipe</span>
            <form  id="form1" method="post" class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

                <input type="hidden" name="recipe_id" value="<?php echo $_GET['id']; ?>" /><!-- hidden id input -->
                <input type="hidden" name="user_id" id="user_id" value="" />
                <div class="form-group d-block col-12 p-0 mb-3">
                  <label class="b7 size14" for="user_name21">User Name:</label>
                  <input type="text" class="form-control rounded-0 p-2" id="user_name21" name="user_name"
                      value="" placeholder="Search User Name..." required />
                  <div id="user_name_dataPar">
                      <ul class="text-left size13 list-group rounded-0 p-0 d-block" id='user_name_data'></ul>
                  </div>
                </div>
              <div class="input-field button">
                <input type="submit" name="share_recipe" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    
</script>
    <?php require_once("parts/footer.php");?>  

<script>
      function itemDone(e) {
        var target = e.target;
        // alert(target.childNode.value);
        e.preventDefault();
        document.getElementById("user_name21").value = target.innerHTML;
        document.getElementById("user_id").value = target.getAttribute('data-id');
        document.getElementById("user_name_data").innerHTML="";
    }
    document.getElementById("user_name_data").addEventListener('click', function(e) {itemDone(e);}, false);

    function showUser(e) {
        let str=e.target.value;
        console.log(str);
        if (str == "") {
            document.getElementById("user_name_data").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("user_name_data").innerHTML = this.responseText;
            }

            };
            xmlhttp.open("GET","search_user_name.php?q="+str,true);
            xmlhttp.send();
        } 
    }
    document.getElementById('user_name21').addEventListener('keyup',function(e){showUser(e)},false);
</script>

