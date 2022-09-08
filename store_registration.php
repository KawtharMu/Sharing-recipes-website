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
	// $mail->SMTPDebug  = 3;
	// $mail->IsSMTP(); 
	// $mail->SMTPAuth = true; 
	// $mail->SMTPSecure = 'tls'; 
	// $mail->Host = "smtp.mailtrap.io";
	// $mail->Port = 2525; 
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
if (isset($_POST['register'])) {
  if ($_POST['password'] != $_POST['confirm_password']) {
    $_SESSION['message']= "Password does not match.";
    $_SESSION['msg_type']= "danger";
    header("Location: register.php");
    exit;
  }
  $query21="select * from users where email=?";

  $stmt21 = $db->prepare($query21);
  
  if ($stmt21) {
    $stmt21->bind_param('s', $_POST['email']);
    $stmt21->execute(); 

    $result21 = $stmt21->get_result();

    if($result21->num_rows > 0){
      $_SESSION['message']= "Email already exists.";
      $_SESSION['msg_type']= "danger";
      header("Location: register.php");
      exit;
    }
  }



    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // md5() function convert pass into hash code
    $status = 0;
    $registration_key = rand(10000,90000);

        // Insert Query
        $query1="insert into users set name=?,email=?,password=?,status=?,registration_key=?";
        $stmt1 = $db->prepare($query1);
        
        if ($stmt1) {
            $stmt1->bind_param('sssss', $name, $email, $password, $status, $registration_key);
            $stmt1->execute();
            
            if ($stmt1->affected_rows == 1) {
              $_SESSION['message']= "We have sent you an email for confirmation.";
              $_SESSION['msg_type']= "success";

              $to = $_POST['email'];
              $subject = "Email Confirmation";

              $message = 'Dear '.$_POST['name'].',<br>';
              $message .= "We welcome you to be part of our family<br><br>";
              $message .= "Email Confirmation Code: ".$registration_key;
              $message .= "<br>Regards,<br>FoodMakers<br>";

              
               smtp_mailer($to,'Email Verification',$message);

  

            } else {
              $_SESSION['message']= "Something went wrong";
              $_SESSION['msg_type']= "danger";
            }

            $stmt1->close(); 



            header("location: verify_email.php");
        }
}


?>