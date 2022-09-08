<?php require_once("parts/header.php");?>
<?php
  if(isset($_SESSION["user_email"])){
    header("Location: index.php");
    exit;
  } 
?>  

    <!-- =====================main section===================== -->
    <section class="main py-5">
      <div class="container py-2" id="registerContainer">
        <div class="forms">
          <!-- Registration Form-->
          <div class="form login">
            <span class="title">Email Verification</span>
            <form id="form1" method="post" action=confirm_email_verification.php class="mt-5 needs-validation1"
                enctype="multipart/form-data">
                <?PHP 
            if (isset($_SESSION['message'])){?>
            <div class="size13 alert alert-<?=$_SESSION['msg_type']?> verCen">
                <?PHP 
                echo $_SESSION['message']; 
                unset($_SESSION['message']) ;
                ?>
            </div>
            <?php } ?>
              <div class="input-field">
                <input type="text" name="registration_key" placeholder="Enter verification code" required />
                <i class="uil uil-user"></i>
              </div>

              <div class="input-field button">
                <input type="submit" name="verify_email" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <?php require_once("parts/footer.php");?>
