<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../api/lib/vendor/autoload.php";



class Mail
{
    private $username = 'admin@fleefood.com';
    private $password = '551512552255';
    private $host = 'mail.privateemail.com';
    private $port = '587';
    private $sender = 'noreply@fleefood.com';
    private $senderName = 'FleeFood';


    public function send($recipient, $subject, $html, $text)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->setFrom($this->sender, $this->senderName);
            $mail->Username   = $this->username;
            $mail->Password   = $this->password;
            $mail->Host       = $this->host;
            $mail->Port       = $this->port;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';

            $mail->addAddress($recipient);

            $mail->isHTML(true);
            $mail->Subject    = $subject;
            $mail->Body       = $html;
            $mail->AltBody    = $text;

            return $mail->Send();
        } catch (Exception $e) { //The leading slash means the Global PHP Exception class will be caught
            var_dump($mail->ErrorInfo);
            return false;
        }
    }
}
