<?php

   use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require (ROOT_PATH . '/assets/phpmailer/src/Exception.php');
    require (ROOT_PATH . '/assets/phpmailer/src/PHPMailer.php');
    require (ROOT_PATH . '/assets/phpmailer/src/SMTP.php');

  
  if (isset($_POST["email"])){
   

    $mail = new PHPMailer(true);
    $body = "Your request has been granted by the COVIK-Tabaco city administration. Welcome to the COVIK team!";
    $userEmail = $_POST["email"];

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'coviktabaco@gmail.com';                     //SMTP username
        $mail->Password   = 'mselgrgvrbimunnf';                               //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('coviktabaco@gmail.com', 'COVIK Mailer');
        $mail->addAddress($userEmail, 'COVIK Recepient');     //Add a recipient

        //Attachments

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'COVIK User Request - Approved';
        $mail->Body    = $body;

        $mail->send();

        if(!$mail->send()) {
            echo '<script>alert("Message could not be sent. Please notify the newly approved user.")</script>';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo '<script>alert("Message has been sent.")</script>';
        }

    } catch (Exception $e) {
    }
  }  

?>