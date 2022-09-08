<?php require_once("parts/header.php"); ?>
<?php
  // echo $_SESSION['user_id'];exit;
  // if(!isset($_SESSION["user_email"])){
  //   header("Location: login.php");
  //   exit;
  // }
  ?>
<style>
  a.selected {
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#FFFFFF;
  border:1px solid #999999;
  cursor:default;
  display:none;
  margin-top: 15px;
  position:absolute;
  text-align:left;
  width:394px;
  z-index:50;
  padding: 25px 25px 20px;
}

label {
  display: block;
  margin-bottom: 3px;
  padding-left: 15px;
  text-indent: -15px;
}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style>
    <!-- =====================main section===================== -->
    <main class="main py-5" id="homePage">
      <div class="container py-5">
        <div class="row">
          <div class="col-lg-7">
            <h1>Welcome To FoodMakers</h1>
            <a href="recipe_list.php">
            <h3>View All Recipes</h3>
            </a>
            <!-- <input type="text" placeholder="Search your dish" />
            <button class="btn2 mt-5"><i class="uil uil-search"></i></button> -->
          </div>
        </div>
      </div>

    </main>

    <?php require_once("parts/footer.php"); ?>
<script>
$(document).ready(function(){
  /* ----- JavaScript ----- */
$(function () {
  $("#custom-modal").modal("show");
});

  $('#accept').on('click',function(){
    var id=$(this).data('id');
    // alert(id);
    $.ajax({
      url: 'acceptinvitation.php',
      type: 'POST',
      data: {id: id},
      success:function(result){
        // alert(result);
        if(result=='true')
        {
          alert('Invitation Accepted...');
          location.reload();
        }
      }
    })  
  })
    $('#decline').on('click',function(){
    var id=$(this).data('id');
    // alert(id);
    $.ajax({
      url: 'deleteinvitation.php',
      type: 'POST',
      data: {id: id},
      success:function(result){
        // alert(result);
        if(result=='true')
        {
          alert('Invitation Decline...');
          location.reload();
        }
      }
    })  
  })

})
</script>