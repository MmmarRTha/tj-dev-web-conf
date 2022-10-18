<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email 
{
    
    public function __construct(
        public string $email, 
        public string $first_name, 
        public string $last_name, 
        public string $token)
    {}

    public function sendConfirmation() 
    {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('account@tjdevwebconf.com');
         $mail->addAddress($this->email, $this->first_name, $this->last_name);
         $mail->Subject = 'Confirm your account';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $content = '<html>';
         $content .= "<p><strong>Hi " .$this->first_name. " " .$this->last_name.  "</strong> Your TJDevWebConf account has been register correctly; but we need your confirmation</p>";
         $content .= "<p>Click Here <a href='" . $_ENV['HOST'] . "/confirm-account?token=" . $this->token . "'>Confirm your Account</a>";       
         $content .= "<p>If you didn't request this confirmation you can ignore it.</p>";
         $content .= '</html>';
         $mail->Body = $content;

         $mail->send();

    }

    public function sendInstructions() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('account@tjdevwebconf.com');
        $mail->addAddress($this->email, $this->first_name, $this->last_name);
        $mail->Subject = 'Recover your password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= "<p><strong>Hi " . $this->first_name .  "</strong> You have been recover your password, follow the next link to complete this request.</p>";
        $content .= "<p>Click here: <a href='" . $_ENV['HOST'] . "/recover?token=" . $this->token . "'>Recover Password</a>";        
        $content .= "<p>If you do not request this change you can ignore this message.</p>";
        $content .= '</html>';
        $mail->Body = $content;

        $mail->send();
    }
}