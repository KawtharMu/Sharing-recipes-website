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
.chosen-container-multi .chosen-choices {
  height: 50px !important;
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
<!-- Theme included stylesheets -->

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="recipe_create_container">
        <div class="forms">
          <!-- Registration Form-->
          <div class="form login">
            <span class="title">Create Recipe</span>
            <form  id="form1" method="post" action=recipe_store.php class="mt-5 needs-validation1"
                enctype="multipart/form-data" >

              <div class="form-group mb-3">
                <label >Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Recipe Name" required />
              </div>
              <div class="form-group mb-3">
                <label >Image</label>
                <input type="file" name="image" class="form-control"  />
              </div>

               <div class="form-group mb-3">
                <label >Description</label>
                <textarea name="details" class="form-control" placeholder="Enter Recipe Description" 
                cols="30" rows="10" ></textarea>
              </div>
              <div class="form-group mb-3">
                <label >Ingredients</label>

                <div class="table rowfy">
                  <div class="tbody">
                      <div class="row tr-row mt-2">
                          <div class="col-10 pr-0">
                            <input type="text" name="ingredients[]" class="form-control" placeholder="Enter Recipe Ingredients" required />
                          </div>
                          <div class="col-2 pr-3 text-right">
                              <div class=" rowfy-addrow btn btn-success btn-block" style="margin-top: 8px;">+</div>
                          </div>
                      </div>
                  </div>
                </div> 
              </div>
              
              <div class="form-group mb-3">
                <label >Instructions</label>

                <div class="table1 rowfy1">
                  <div class="tbody1">
                      <div class="row tr-row1 mt-2">
                          <div class="col-10 pr-0">
                            <input type="text" name="description[]" class="form-control" placeholder="Enter Recipe instruction" required />
                          </div>
                          <div class="col-2 pr-3 text-right">
                              <div class=" rowfy-addrow1 btn btn-success btn-block" style="margin-top: 8px;">+</div>
                          </div>
                      </div>
                  </div>
                </div> 
              </div>
              <div class="input-field button">
                <input type="submit" name="insert_recipe" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
 
</script>
    <?php require_once("parts/footer.php");?>  
<script>

  $(document).ready(function($) {

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
  // $(".chosen-select").chosen();
</script>