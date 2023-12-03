<?php

   use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require (ROOT_PATH . '/assets/phpmailer/src/Exception.php');
    require (ROOT_PATH . '/assets/phpmailer/src/PHPMailer.php');
    require (ROOT_PATH . '/assets/phpmailer/src/SMTP.php');

  
  if (isset($_GET["message"]) && isset($_GET["email"])){
   

    $mail = new PHPMailer(true);
    $body = $_GET["message"];
    $userEmail = $_GET["email"];

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
        $mail->addAddress('coviktabaco@gmail.com', 'COVIK Recepient');     //Add a recipient

        //Attachments

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'COVIK User Message';
        $mail->Body    = $body . "  from: " . $userEmail;

        $mail->send();

        if(!$mail->send()) {
            echo '<script>alert("Message could not be sent.")</script>';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo '<script>alert("Message has been sent.")</script>';
        }

    } catch (Exception $e) {
    }
  }  

?>


<footer>
     <div class="footer-content">
          <div class="footer-section about">
               <a href="<?php echo BASE_URL . '/index.php'; ?>">
                    <h1 class="logo-text"><span>COVIK</span> Tabaco</h1>
               </a>
               <p>
               COVIK-Tabaco (Covid-19 Virtual Information Kiosk) is a platform aimed to counter the threats of misinformation concerning
                    Covid-19, and to provide a centralized hub for credible information. 
               </p>
               <div class="contact">
                    <span><i class="fas fa-phone"></i>&nbsp; 0967-7531-654</span>
                    <span><i class="fas fa-envelope"></i>&nbsp; chutabaco.4511@gmail.com</span>
               </div>
               <div class="socials">
                    <a href="https://www.facebook.com/CityHealthUnitTabaco"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
               </div>
          </div>

          <div class="footer-section links">
               <h2>Quick Links</h2>
               <br />
               <ul>
                    <a href="https://www.facebook.com/TabacoCity/"><li>LGU Tabaco</li></a>
                    <a href="<?php echo BASE_URL . '/about.php' ?>"><li>About Covik</li></a>
                    <a href="https://www.facebook.com/CityHealthUnitTabaco"><li>CHU Tabaco</li></a>
                    <a href="https://www.facebook.com/commandcentertabaco/"><li>Covid-19 Command Center</li></a>
                    <a href="<?php echo BASE_URL . '/developers.php' ?>"><li>Developers</li></a>
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank"><li>Terms and Conditions</li></a>
               </ul>
          </div>

          <div class="footer-section contact-form">
               <h2>Contact us</h2><span></span><h3 class="sent-notification"></h3>
               <br />
               <form action="<?php $_PHP_SELF ?>" method="GET" id="myForm">
                    <input type="text" name="email" id="email" class="text-input contact-input" placeholder="Your email address..."/>
                    <textarea rows="4" name="message" id="email-body" class="text-input contact-input" placeholder="Your message..."></textarea>
                    <input type="submit"  class="btn btn-big contact-btn">
                    </input>
               </form>
          </div>
     </div>

     <div class="footer-bottom">
          &copy; Designed by Rainier Barbacena & Tom Justine Militante
     </div>
</footer>