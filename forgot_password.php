<?php require_once("parts/header.php");?>
<?php
  if(isset($_SESSION["user_email"])){
    header("Location: index.php");
    exit;
  } 
?>  


    
<style>
  #recipe_create_container {
    margin-top: 50px;
    width: 40%;
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
    padding: 15px;
    border-radius: 6px;
}

</style>

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="recipe_create_container">
        <div class="forms">
          <!-- Registration Form-->
          <div class="form login">
            <span class="title">Email Verification</span>
            <?PHP 
            if (isset($_SESSION['message'])){?>
            <div class="size13 alert alert-<?=$_SESSION['msg_type']?> verCen">
                <?PHP 
                echo $_SESSION['message']; 
                unset($_SESSION['message']) ;
                ?>
            </div>
            <?php } ?>
            <form method="post" action=forgot_password1.php class="mt-5 needs-validation1"
                enctype="multipart/form-data">
                <div class="row">
                  <div class="col-9">
                    <input type="text" name="email" placeholder="Enter Email Address" required />
                  </div>

                  <div class="col-3">
                    <input type="submit" name="get_forgot_password_code" value="Get Code" />
                  </div>
                </div>
              
            </form>

            <form id="form1" method="post" action=forgot_password1.php class="mt-5 needs-validation1"
                enctype="multipart/form-data">
                
              <div class="input-field">
                <input type="text" name="reset_password_key" placeholder="Enter verification code" required />
              </div>
              <div class="input-field">
                <input type="password" name="password" placeholder="Enter New password" required />
              </div>

              <div class="input-field button">
                <input type="submit" name="set_updated_password" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <?php require_once("parts/footer.php");?>
