
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
            <span class="title">Recipes List  <!-- <a href="sharedreciepeslist.php" class="btn btn-primary"  style="margin-left: 1020px;text-decoration: none;">
  Shared Management</a> --></span>
           
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
                <th class="b7">Date Of Publication</th>
                <th class="b7">Who wrote it</th>
                <th class="b7">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT r.id, r.user_id, r.name, r.created_at, u.name as user_name  from recipes  as r JOIN users as u ON r.user_id = u.id WHERE r.user_id=? UNION SELECT r.id, r.user_id, r.name, r.created_at, u.name as user_name  from share_recipes sh LEFT JOIN recipes r ON r.id=sh.recipe_id LEFT JOIN users u ON u.id=sh.user_id WHERE sh.user_id=?";
                
                $stmt1 = $db->prepare($query);
                $sr=1;
                if($stmt1)
                {
                      $stmt1->bind_param('ii', $_SESSION['user_id'],$_SESSION['user_id']);
                      $stmt1->execute(); 
                      $result = $stmt1->get_result();

                    while($r=$result->fetch_array(MYSQLI_ASSOC))
                    {
                ?>

                <tr>
                    <td class="size13"><?php echo $sr;  ?></td>
                    <td class="size13"><a href="recipe_view_share.php?id=<?php echo $r['id'] ?>" target="_blank"><?php echo $r['name']  ?></a></td>
                    <td class="size13"><?php echo (date_format(new DateTime($r['created_at']), 'd M, Y'))  ?></td>
                    <td class="size13"><?php echo $r['user_name']  ?></td>
                    <td>
                        <?php 
                        // echo '<a href="recipe_share.php?id='.$r['id'].'" class="btn btn-info text-white">Share</a> &nbsp &nbsp &nbsp';
                        if($_SESSION['user_id']==$r['user_id']){
                        echo '<a href="recipe_edit.php?id='.$r['id'].'" class="btn btn-warning text-white">Update</a> &nbsp &nbsp &nbsp';
                        echo '<a href="recipe_delete.php?delete_id='.$r['id'].'" class="btn btn-danger text-white">Delete</a> &nbsp &nbsp &nbsp';
                        }
                        ?>
                    </td>


                </tr>
                <?php  
                   $sr++; }
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
  


  
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script> -->


    <?php require_once("parts/footer.php");?>  

<script>
  $(document).ready( function () {
    $('#table_id').DataTable();
} );

</script>