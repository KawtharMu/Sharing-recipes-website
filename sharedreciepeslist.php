
<?php

include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();
?>





<?php require_once("parts/header.php");?>

<?php
  if(!isset($_SESSION["user_email"])){
    header("Location: login.php");
    exit;
  } 

if(isset($_POST['share_recipe'])){
    $recipe_owner_id=$_SESSION['user_id'];
    $recipe_id=$_POST['recipe_id'];
    // $user_id=$_POST['user_id'];
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

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

    
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
    <!-- =====================Recipes section===================== -->

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="recipe_create_container">
        <div class="forms">
          <div class="form login">
            <span class="title">Shared Receipes</span>
            <?PHP 
            if (isset($_SESSION['message'])){?>
            <div class="size13 alert alert-<?=$_SESSION['msg_type']?> verCen">
                <?PHP 
                echo $_SESSION['message']; 
                unset($_SESSION['message']) ;
                ?>
            </div>
            <?php } ?>
            <div class="container table-responsive mt-5">
        <table id="table_id" class="table table-light table-striped table-bordered">
          <thead>
            <tr class="thead-dark">
                <th class="b7">#</th>
                <th class="b7">Receipe Name</th>
                <th class="b7">Shared With</th>
                <th class="b7">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT sr.recipe_id,sr.id as share_id, sr.recipe_owner_id, r.name as receipe,u.name as user from share_recipes as sr JOIN users as u 
                            ON sr.user_id = u.id JOIN recipes as r ON sr.recipe_id = r.id  
                            where sr.status=? order by sr.id desc";
                
                $stmt1 = $db->prepare($query);
                $sr=1;
                if($stmt1)
                {
                  $status = '1';
                      $stmt1->bind_param('s', $status);
                      $stmt1->execute(); 
                      $result = $stmt1->get_result();

                    while($r=$result->fetch_array(MYSQLI_ASSOC))
                    {

                ?>

                <tr>
                    <td class="size13"><?php echo $sr;  ?></td>
                    <td class="size13"><?php echo $r['receipe']  ?></td>
                    <td class="size13"><?php echo ucfirst($r['user']);  ?></td>
                    <td>
                        <?php 
                        echo '<a href="recipe_view.php?id='.$r['recipe_id'].'" class="btn btn-info text-white">View</a> &nbsp &nbsp &nbsp';
                        if($r['recipe_owner_id']==$_SESSION['user_id']){
                        echo '<a href="delsharedreceipe.php?id='.$r['recipe_id'].'" class="btn btn-danger text-white">Delete</a> &nbsp &nbsp &nbsp';
                        ?>
                        <button type="button" class="btn btn-success models" data-id="<?php echo $r['recipe_id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Shared With Other Users</button>
                      <?php }else{
                        echo '<a href="declinesharedrecipe2.php?id='.$r['share_id'].'" class="btn btn-danger text-white">Decline</a> &nbsp &nbsp &nbsp';
                      }
                        
                        ?>
                        

                    </td>
                </tr>
                <?php  
                  $sr++;  }
                } 
                mysqli_free_result($result);
                // OR
                // $stmt2->close()
                ?>
            </tbody>
        </table>
    </div>
    <!-- End of View Data List -->
          </div>
        </div>
      </div>
    </section>
  

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Share Recepie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>If you Like this receipe,Enter and Email or Username you want to share it to!</p>
        <form  id="form1" method="post" class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

                <input type="hidden" name="recipe_id" id="recipe_id" value="" /><!-- hidden id input -->
                <input type="hidden" name="user_id" id="user_id" value="" />
                <div class="form-group d-block col-12 p-0 mb-3">
                  <label class="b7 size14" for="user_name21">User Name:</label>
                  <input type="text" class="form-control rounded-0 p-2" id="user_name21" name="user_name"
                      value="" placeholder="Search User Name..." required />

                  <div id="user_name_dataPar">
                      <ul class="text-left size13 list-group rounded-0 p-0 d-block" id='user_name_data'></ul>
                  </div>
                </div>
              <div class="">
                <input type="submit" class="btn btn-primary" name="share_recipe" value="Submit" />
              </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<script>
  $(document).ready( function () {
    $('#table_id').DataTable();
} );

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

    $('.models').on('click',function(){
        var id=$(this).data('id');
            $('#recipe_id').val(id);
    })
</script>

