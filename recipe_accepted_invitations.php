
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
            <span class="title">Accepted Recipe Invitations</span>
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
                <th class="b7">Name</th>
                <th class="b7">Who wrote it</th>
                <th class="b7">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT sr.id, sr.recipe_owner_id, sr.recipe_id, sr.user_id, sr.status, r.name, 
                          u.name as user_name  from share_recipes as sr JOIN users as u 
                          ON sr.recipe_owner_id = u.id JOIN recipes as r ON sr.recipe_id = r.id 
                          where sr.user_id=? and sr.status=? order by sr.id desc";
                
                $stmt1 = $db->prepare($query);
                
                if($stmt1)
                {
                  $status = '1';
                      $stmt1->bind_param('is', $_SESSION['user_id'], $status);
                      $stmt1->execute(); 
                      $result = $stmt1->get_result();

                    while($r=$result->fetch_array(MYSQLI_ASSOC))
                    {
                ?>

                <tr>
                    <td class="size13"><?php echo $r['id']  ?></td>
                    <td class="size13"><?php echo $r['name']  ?></td>
                    <td class="size13"><?php echo $r['user_name']  ?></td>
                    <td>
                        <?php 
                        echo '<a href="recipe_view.php?id='.$r['recipe_id'].'" class="btn btn-info text-white">View</a> &nbsp &nbsp &nbsp';
                        
                        ?>
                    </td>
                </tr>
                <?php  
                    }
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
  


  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<script>
  $(document).ready( function () {
    $('#table_id').DataTable();
} );

</script>
    <?php require_once("parts/footer.php");?>  

