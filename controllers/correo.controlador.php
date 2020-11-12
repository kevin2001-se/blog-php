<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ControladorCorreo
{

    static public function ctrEnviarCorreo()
    {
        if (isset($_POST["nombreContacto"])) {

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
               /*  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp1.example.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'user@example.com';                     // SMTP username
                $mail->Password   = 'secret';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;    */                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                $mail -> isMail();

                //Recipients
                $mail->setFrom($_POST["emailContacto"], $_POST["nombreContacto"]);
                $mail->addAddress('juanitotravel@vlogviajero.com', 'Juanito Travel');     // Add a recipient
                /* $mail->addAddress('ellen@example.com');  */              // Name is optional
                $mail->addReplyTo($_POST["emailContacto"], $_POST["nombreContacto"]);
               /*  $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com'); */

                // Attachments
               /*  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); */    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Mensaje del Blog';
                $mail->Body    = '<div style="margin:20px">'.$_POST['mensajeContacto'].'</div>';
                $mail->AltBody = $_POST["mensajeContacto"];

                $mail->send();
                return 'ok';
            } catch (Exception $e) {
                return "error";
            }
        }
    }
}
