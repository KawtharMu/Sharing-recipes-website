<?php
// session_start();
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

    
  // $query21="select * from recipes where id=?";

  // $stmt21 = $db->prepare($query21);
  
  // if ($stmt21) {
  //   $stmt21->bind_param('i', $_GET['id']);
  //   $stmt21->execute(); 

  //   $result21 = $stmt21->get_result();

    // if($result21->num_rows < 1){
      
    //   $query221="select * from share_recipes where recipe_id=? and status=? and user_id=?";
    //   $stmt221 = $db->prepare($query221);
      
    //   if ($stmt221) {
    //     $share_status = '1';
    //     $stmt221->bind_param('ssi', $_GET['id'], $share_status, $_SESSION['user_id']);
    //     $stmt221->execute(); 

    //     $result221 = $stmt221->get_result();

    //     if($result221->num_rows < 1){
    //       // $_SESSION['message']= "Email already exists.";
    //       // $_SESSION['msg_type']= "danger";
    //       header("Location: recipe_list.php");
    //       exit;
    //     }
    //   }
    // }
  // }

    $query1="select  r.id, r.name, r.description, r.ingredients,r.details,r.image, r.created_at,r.user_id, u.name as user_name  from recipes  as r JOIN users as u ON r.user_id = u.id
where r.id=? order by r.id desc";
// echo $query1;exit;
    $stmt1 = $db->prepare($query1);
    
    if ($stmt1) {
        $stmt1->bind_param('i', $id);

        // var_dump($stmt1);exit;
        $stmt1->execute(); 

        $result = $stmt1->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $name = $row["name"];
            $description = $row["description"];
            $ingredients = $row["ingredients"];
            $instructions = $row["description"];
            $details = $row["details"];
            $image = $row["image"];
            $user_name = $row["user_name"];
            $onwer_id = $row["user_id"];
            $created_at = $row["created_at"];

            
        } else{
            // URL doesn't contain valid id. Redirect to error page
            // exit();
        }

        $stmt1->close(); 
    }else{
        //oops something went wrong
    }



}
  //Receipe Share Process


if(isset($_POST['share_recipe'])){
    $recipe_owner_id=$_SESSION['user_id'];
    $recipe_id=$_POST['recipe_id'];
    $user_id=$_POST['user_id'];
    $username=$_POST['user_name'];

    $status= 0;
     $query1="select id from users where name=? or email=?";
// echo $query1;exit;
    $stmt1 = $db->prepare($query1);
    
    if ($stmt1) {
        $stmt1->bind_param('ss', $username,$username);

        // var_dump($stmt1);exit;
        $stmt1->execute(); 

        $result = $stmt1->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $user_id = $row["id"];

            
        }
      }
      // Insert Query
      $query1="insert into share_recipes set recipe_owner_id=?,recipe_id=?,user_id=?,status=?";
      $stmt1 = $db->prepare($query1);
      
      if ($stmt1) {
        $stmt1->bind_param('iiis', $recipe_owner_id, $_GET['id'], $user_id, $status);
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
input:checked + label {
  color:blue;
  text-decoration: line-through;
}
input[type=checkbox] {
  position: relative;
  width: 1.5em;
  height: 1.5em;
  color: #363839;
  border: 1px solid #bdc1c6;
  border-radius: 4px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  outline: 0;
  cursor: pointer;
  transition: background 175ms cubic-bezier(0.1, 0.1, 0.25, 1);
}
input[type=checkbox]::before {
  position: absolute;
  content: "";
  display: block;
  top: 2px;
  left: 7px;
  width: 8px;
  height: 14px;
  border-style: solid;
  border-color: #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
  opacity: 0;
}
input[type=checkbox]:checked {
  color: #fff;
  border-color: #06842c;
  background: #06842c;
}
input[type=checkbox]:checked::before {
  opacity: 1;
}
input[type=checkbox]:checked ~ label::before {
  -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
          clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
}
#label {
  position: relative !important;
  cursor: pointer !important;
  font-size: 1.2em !important;
  font-weight: 600 !important;
  padding: 0.1em 0.25em 0 !important;
  -webkit-user-select: none !important;
     -moz-user-select: none !important;
      -ms-user-select: none !important;
          user-select: none !important;
}

.form-check .form-check-input {
    float: none !important;
    margin-left: 0.5em !important;
}
</style>

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="recipe_create_container">
        <div class="forms">
          <div class="form login">
            <span class="title">View Recipe</span>
            <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float:right;">
  Share Managment</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Share Managment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php if($onwer_id ==$_SESSION['user_id']){ 

          ?>
       
        
        <table>
                  <?php $sql="SELECT sr.*,u.name FROM share_recipes sr join users u on u.id=sr.user_id WHERE sr.recipe_id=? AND sr.recipe_owner_id=? ";
                         $stmt1 = $db->prepare($sql);
                      
                  if ($stmt1) {
                      $stmt1->bind_param('ii', $_GET['id'],$_SESSION['user_id']);
                      // var_dump($stmt1);exit;
                      $stmt1->execute(); 

                  $result = $stmt1->get_result();
                  if($result->num_rows >0){
                    echo '<p>This is Receipe Is Share With.</p>';
                while($r=$result->fetch_array(MYSQLI_ASSOC)){
                  // var_dump($r);
                       ?>
                       <tr>
                  <th><?php echo ucfirst($r['name']); ?> </th>
                  <th><button type="button" class="btn btn-danger btn-sm remove_recipe" style="margin-left: 70px;"  data-id="<?php echo $_GET['id']; ?>" data-user="<?php echo $r['user_id']; ?>">Remove</button></th>
                   </tr>
                   <tr>
                     <td colspan="2">&nbsp;</td>
                   </tr> 
                  <?php } } else{?>
                        <tr><th style="padding-bottom: 30px" colspan="2">This Recipe Is Not Share Yet With Any Users..</th></tr>
                <?php   } } ?>
                </table>
                 <p>If you Like this receipe,Enter and Email or Username you want to share it to!</p>
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
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6"><input type="submit" class="bt btn-primary" name="share_recipe"  value="Share" /></div>
                  <div class="col-md-6"><button type="button" class="btn btn-secondary" style="height: 58px;width: 100%;" data-bs-dismiss="modal">Cancel</button></div>
                </div>
                
                
              </div>
            </form>
          <?php } else{?>
                <p>This is Receipe Is Share With.</p>
                <table>
                  <?php $sql="SELECT sr.*,u.name as users FROM share_recipes sr join users u on u.id=sr.user_id WHERE recipe_id=?";
                         $stmt1 = $db->prepare($sql);
    
                  if ($stmt1) {
                      $stmt1->bind_param('i', $_GET['id']);
                      $stmt1->execute(); 

                  $result = $stmt1->get_result();

             while($r=$result->fetch_array(MYSQLI_ASSOC)){
                       ?>
                       <tr>
                  <th><?php echo ucfirst($r['users']); ?></th>
                      </tr>
                    <?php } ?>  
                </table><hr> 
                <div class="row">
                  <div class="col-md-6"> <button type="button" class="btn btn-danger " style="height: 58px;width: 100%;" id="leave_recipe" data-id="<?php echo $_GET['id']; ?>" data-user="<?php echo $_SESSION['user_id']; ?>">Leave</button></div>
                  <div class="col-md-6"><button type="button" class="btn btn-secondary " style="height: 58px;width: 100%;" data-bs-dismiss="modal">Cancel</button></div>
                </div>
               
                
         <?php   } } ?>
      </div>
      <!-- <div class="modal-footer"> -->
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      <!-- </div> -->
    </div>
  </div>
</div>
            <!-- <a href="recipe_share.php" class="btn btn-info text-white" style="margin-left: 900px;">Share</a> -->
            <form  id="form1" class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

              <div class="form-group mb-3">
                <label >Name</label>
                <input type="text" name="name" value="<?php echo $name  ?>" class="form-control" placeholder="Enter Recipe Name" readonly />
              </div>
              <div class="form-group mb-3">
                <div class="row">
                  <div class="col-md-8">
                    <label >Description</label>
                <textarea name="description" class="form-control" placeholder="Enter Recipe Description" 
                cols="30" rows="10" readonly=""><?php echo $details  ?></textarea>
                  </div>
                  <div class="col-md-4">
                    <label for="">Image</label><br>
                    <img src="imgs/<?php echo $image  ?>" class="img-responsive" style="width: 400px;height: 250px" alt="">
                  </div>
                </div>
              </div>
              <div class="form-group mb-3">
                <label style="font-size: 30px;text-decoration: underline;padding-bottom: 5px">Ingredients</label><br>
                <!-- <input type="checkbox" id="cbox3" value="third_checkbox"> <label for="cbox3"> Can I only select an ID? </label> -->
                <?php
                $string = rtrim($ingredients, ',');
                // var_dump($);exit;
                 $ingredients=explode(',', $string);
                // var_dump($ingredients);exit;
                      for ($i=0; $i<count($ingredients); $i++) {
                 ?>
                 <input class="form-check-input" type="checkbox" name="ingredients[]" value="" id="flexCheckDefault">
                  <label class="form-check-label" id="label" for="flexCheckDefault">
                   <?php echo $ingredients[$i] ?>
                  </label>   <br>     
                <?php } ?>
                <!-- <input type="text" name="ingredients"  value="<?php echo $ingredients  ?>" class="form-control" placeholder="Enter Recipe Ingredients" readonly /> -->
              </div>
              <div class="form-group mb-3">
                <label style="font-size: 30px;text-decoration: underline;padding-bottom: 5px">Steps</label><br>
                <!-- <input type="checkbox" id="cbox3" value="third_checkbox"> <label for="cbox3"> Can I only select an ID? </label> -->
                <?php
                $string = rtrim($instructions, ',');
                // var_dump($);exit;
                 $instructions=explode(',', $string);
                // var_dump($ingredients);exit;
                      for ($i=0; $i<count($instructions); $i++) {
                 ?>
                 <input class="form-check-input" type="checkbox" name="ingredients[]" value="" id="flexCheckDefault">
                  <label class="form-check-label" id="label" for="flexCheckDefault">
                   <?php echo $instructions[$i] ?>
                  </label>   <br>     
                <?php } ?>
              </div>
              <div class="form-group mb-3">
                <label >Owner Name</label>
                <input type="text" name="user_name"  value="<?php echo $user_name  ?>" class="form-control" readonly />
              </div>
              <div class="form-group mb-3">
                <label >Published At</label>
                <input type="text" name="created_at"  value="<?php echo (date_format(new DateTime($created_at), 'd M, Y'))  ?>" class="form-control" placeholder="Enter Recipe Ingredients" readonly />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  
  
<?php require_once("parts/footer.php");?>  
<script>
   $(document).on('click','#leave_recipe',function(){
        var recipe_id=$(this).data('id');
        var user_id=$(this).data('user');
        $.ajax({
          url: 'leave_share_receipe.php',
          type: 'POST',
          data: {recipe_id:recipe_id,user_id:user_id},
          success:function(output)
          {
            if(output=='true') { location.reload(); }
          }
        })
    })

       $(document).on('click','.remove_recipe',function(){
        var recipe_id=$(this).data('id');
        var user_id=$(this).data('user');
        $.ajax({
          url: 'remove_share_receipe.php',
          type: 'POST',
          data: {recipe_id:recipe_id,user_id:user_id},
          success:function(output)
          {
            if(output=='true') { location.reload(); }
          }
        })
    })
</script>
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

