<?php

session_start();

include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();

if(isset($_SESSION["user_email"])){
  header("Location: index.php");
  exit;
} 
 
include('smtp/PHPMailerAutoload.php');
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "websitetest118@gmail.com";
	$mail->Password = "huzctqcwtzvbcfzs";
	$mail->SetFrom("websitetest118@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return 'Sent';
	}
}

//insert reocrd
if (isset($_POST['get_forgot_password_code'])) {
  $email = $_POST['email'];
  $reset_password_key = rand(10000,90000);

  $query1="select * from users  where email=?";

  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
    $stmt1->bind_param('s', $email);
    $stmt1->execute(); 

    $result = $stmt1->get_result();

    if($result->num_rows > 0){
      $query2 = "UPDATE users SET reset_password_key=? WHERE email=?";
      $stmt3 = $db->prepare($query2);
      
      if ($stmt3) {
        $stmt3->bind_param('ss', $reset_password_key, $email);
        $stmt3->execute();
      }

      $_SESSION['message']= "We have sent you a verification code for confirmation.";
      $_SESSION['msg_type']= "success";

      $to = $_POST['email'];
      $subject = "Email Confirmation";

      $message .= "Reset Password Code: ".$reset_password_key;
      
      smtp_mailer($to,'Reset Password Emaail',$message);

      // Always set content-type when sending HTML email
      // $headers = "MIME-Version: 1.0" . "\r\n";
      // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // // More headers
      // $headers .= 'From: <ahsanrao237@gmail.com>' . "\r\n";
      // // $headers .= 'Cc: myboss@example.com' . "\r\n";

      // mail($to,$subject,$message,$headers);

      header("location: forgot_password.php");
        
    } else{
      $_SESSION['message']= "Email does not exist.";
      $_SESSION['msg_type']= "danger";
      header("location: forgot_password.php");
    }

    $stmt1->close(); 
  }else{
    $_SESSION['message']= "Something went wrong";
    $_SESSION['msg_type']= "danger";
    header("location: forgot_password.php");
  }
}


//insert reocrd
if (isset($_POST['set_updated_password'])) {
  $reset_password_key = $_POST['reset_password_key'];
  $password = md5($_POST['password']);

  $query1="select * from users  where reset_password_key=?";

  $stmt1 = $db->prepare($query1);
  
  if ($stmt1) {
    $stmt1->bind_param('s', $reset_password_key);
    $stmt1->execute(); 

    $result = $stmt1->get_result();

    if($result->num_rows > 0){
      $query2 = "UPDATE users SET password=? WHERE reset_password_key=?";
      $stmt3 = $db->prepare($query2);
      
      if ($stmt3) {
        $stmt3->bind_param('ss', $password, $reset_password_key);
        $stmt3->execute();
      }

      $_SESSION['message']= "Password reset successfully";
      $_SESSION['msg_type']= "success";

      header("location: login.php");
        
    } else{
      $_SESSION['message']= "Incorrect Key.";
      $_SESSION['msg_type']= "danger";
      header("location: forgot_password.php");
    }

    $stmt1->close(); 
  }else{
    $_SESSION['message']= "Something went wrong";
    $_SESSION['msg_type']= "danger";
    header("location: forgot_password.php");
  }
}
?>