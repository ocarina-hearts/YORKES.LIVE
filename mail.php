<?php

//uNeZ0NXoSSqD


//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//date_default_timezone_set('Etc/UTC');

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

//Drops HTTP resquests only allowing AJAX. 
define('AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!AJAX_REQUEST) {die();}

//AJAX ripping in variables with a little sanitation 

# sanitize form data
function clean($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

$name = clean($_POST['name']);
$email = clean($_POST['email']);
$subject = clean($_POST['subject']);
$interest = clean($_POST['interest']);
$pitfall = clean($_POST['pitfall']);
$message = clean($_POST['message']);

//Serverside error handling 
header('Content-Type: application/json');
if ($name === ''){
  echo json_encode(array('message' => 'Name cannot be empty', 'code' => 0));
  exit();
}
if ($email === ''){
  print json_encode(array('message' => 'Email cannot be empty', 'code' => 0));
  exit();
} else {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
  print json_encode(array('message' => 'Email format invalid.', 'code' => 0));
  exit();
  }
}
if ($subject === ''){
  print json_encode(array('message' => 'Subject cannot be empty', 'code' => 0));
  exit();
}
//this is the honeypot
if ($pitfall !== ''){
  print json_encode(array('message' => 'Email sent.', 'code' => 0));
  exit();
}
if ($message === ''){
  print json_encode(array('message' => 'Message cannot be empty', 'code' => 0));
  exit();
}

//Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
  $mail->isSMTP();

  //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

  //SERVER SETTINGS
  $mail->Host = 'mail.yorkes.live';
  $mail->Port = 465;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "ssl";
  $mail->Username = 'webmaster@yorkes.live';
  $mail->Password = 'uNeZ0NXoSSqD';

  //Set who the message is to be sent from
  $mail->setFrom('webmaster@westburydigital.com.au', 'Webserver');

  //Set an alternative reply-to address
  $mail->addReplyTo($email);

  //Set who the message is to be sent to
  $mail->addAddress('dave@westburydigital.com.au', 'Dave');


  //Set the subject line
  $mail->Subject = 'A new email from your website';

  //Email main body
  $mail->msgHTML('Name: <br><b>' . $name . '</b><br><br>Email: <br><b>' . $email . '</b><br><br>Subject: <br><b>' . $subject . '</b><br><br>Interest Dropdown: <br><b>' . $interest . '</b><br><br>Message: <br><b>' .  $message . '</b><br><br><br>This email was generated from the online website form.');
  
  //Replace the plain text body with one created manually
  $mail->AltBody = 'This is a plain-text message body';
  //Attach an image file
  //$mail->addAttachment('images/phpmailer_mini.png');
  
  //SENDIT
  if (!$mail->send()) {
    print json_encode(array('success' => true, 'message' => 'Hmm.. This is embarrassing. The email failed. Do you think you could send me a letter?', 'code' => 1));
    exit();
   } else {
    print json_encode(array('success' => true, 'message' => 'Email sent.', 'code' => 1));
    exit();
   }

} 
catch (Exception $e) 
{
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} 
catch (\Exception $e) 
{ //The leading slash means the Global PHP Exception class will be caught
    echo $e->getMessage(); //Boring error messages from anything else!
}

?>