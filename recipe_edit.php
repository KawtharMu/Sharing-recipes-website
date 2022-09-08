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

    $query1="select  r.id, r.name, r.description,r.ingredients,r.details,  r.created_at, u.name as user_name  from recipes  as r JOIN users as u ON r.user_id = u.id where r.id=? order by r.id desc";
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

            $description = explode(',',$row["description"]);
            $string = rtrim($row["ingredients"], ',');
            $ingredients = explode(',',$string);

            $user_name = $row["user_name"];
            $details = $row["details"];
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
.chosen-container-multi .chosen-choices {
  height: 50px !important;
}
</style>

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="recipe_create_container">
        <div class="forms">
          <div class="form login">
            <span class="title">Edit Recipe</span>
            <form  id="form1" method="post" action=recipe_update.php class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

                <input type="hidden" name="id" value="<?php echo $id; ?>" /><!-- hidden id input -->

                <div class="form-group mb-3">
                <label >Name</label>
                <input type="text" name="name" value="<?php echo $name  ?>" class="form-control" placeholder="Enter Recipe Name" required />
              </div>
              <div class="form-group mb-3">
                <label >Description</label>
                <textarea name="details" class="form-control" placeholder="Enter Recipe Description" 
                cols="30" rows="10" ><?php echo $details  ?></textarea>
              </div>
             <div class="form-group mb-3">
                <label >Ingredients</label>

                <div class="table rowfy">
                  <div class="tbody">
                    <?php
                      // echo $ingredients;
                     foreach($ingredients as $key => $ingred) {
                          // var_dump($ingred);exit;
                      ?>
                      <div class="row tr-row mt-2">
                          <div class="col-10 pr-0">
                            <input type="text" name="ingredients[]" value="<?php echo ($ingred)  ?>" class="form-control" placeholder="Enter Recipe Ingredients" <?php if( count($ingred) != $key + 1 ) {echo "required"; } else{ echo "";} ?>  />
                          </div>
                          <div class="col-2 pr-3 text-right">
                            <?php if( count($ingredients) == $key + 1 ) { ?>
                              <div class=" rowfy-addrow btn btn-success btn-block" style="margin-top: 8px;">+</div>
                          <?php } else { ?>
                              <div class=" rowfy-deleterow btn btn-danger btn-block" style="margin-top: 8px;">-</div>
                          <?php } ?>
                          </div>
                      </div>
                       <?php } ?>
                  </div>
                </div> 
              </div>
              
              
              
              <div class="form-group mb-3">
                <label >Instructions</label>
                <div class="table1 rowfy1">
                  <div class="tbody1">
                    <?php foreach($description as $key => $descrip) { ?>
                      <div class="row tr-row1 mt-2">
                          <div class="col-10 pr-0">
                            <input type="text" name="description[]" value="<?php echo ($descrip)  ?>"  class="form-control" placeholder="Enter Recipe instructions" <?php if( count($description) != $key + 1 ) {echo "required"; } else{ echo "";} ?>  />
                          </div>
                          <div class="col-2 pr-3 text-right">
                          <?php if( count($description) == $key + 1 ) { ?>
                              <div class=" rowfy-addrow1 btn btn-success btn-block">+</div>
                          <?php } else { ?>
                              <div class=" rowfy-deleterow1 btn btn-danger btn-block">-</div>
                          <?php } ?>
                          </div>
                      </div>
                    <?php } ?>
                  </div>
                </div> 
              </div>
              <div class="input-field button">
                <input type="submit" name="update_recipe" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  
  
</script>
    <?php require_once("parts/footer.php");?>  

<script>
   $(document).ready(function () {
     $(".chosen-select").chosen(); 

           /*Add row event*/
        $(document).on('click', '.rowfy-addrow', function(){
            // var totalAdd = $('.tr-row').length;
            // if(totalAdd > 0)
            //     $('.finish-btn a').css({'display': 'inline-block'});

            rowfyable = $(this).closest('.table');
            lastRow = $('.tbody .tr-row:last', rowfyable).clone();
            $('input', lastRow).val(''); //$('input', lastRow) -> this expression is equal to $( lastRow ).find( "input" )
            $('.tbody', rowfyable).append(lastRow);
            $(this).removeClass('rowfy-addrow btn-success').addClass('rowfy-deleterow btn-danger').text('-');
        });

        /*Delete row event*/
        $(document).on('click', '.rowfy-deleterow', function(){
            $(this).closest('.tr-row').remove();
        });

     
     $(document).on('click', '.rowfy-addrow1', function(){
            // var totalAdd = $('.tr-row').length;
            // if(totalAdd > 0)
            //     $('.finish-btn a').css({'display': 'inline-block'});

            rowfyable = $(this).closest('.table1');
            lastRow = $('.tbody1 .tr-row1:last', rowfyable).clone();
            $('input', lastRow).val(''); //$('input', lastRow) -> this expression is equal to $( lastRow ).find( "input" )
            $('.tbody1', rowfyable).append(lastRow);
            $(this).removeClass('rowfy-addrow1 btn-success').addClass('rowfy-deleterow1 btn-danger').text('-');
        });

        /*Delete row event*/
        $(document).on('click', '.rowfy-deleterow1', function(){
            $(this).closest('.tr-row1').remove();
        });
});
 
</script>