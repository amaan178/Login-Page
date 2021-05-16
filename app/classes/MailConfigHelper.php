<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class MailConfigHelper
{
    public static function getMailer(int $debugMode = 0): PHPMailer
    {
        $mail = new PHPMailer();
        $mail->SMTPDebug = $debugMode;
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->Port = 2525;
        $mail->SMTPAuth = true;
        $mail->Username = '20b1b58c70717f';
        $mail->Password = 'bd4533db057d70';
        $mail->SMTPSecure = 'tls';   //Transport Layer Security for encryption
        $mail->isHtml(true);
        // Our email
        $mail->setFrom('admin@amaan123.com', 'Admin<Amaan Jambura>');

        return $mail;
    }
}