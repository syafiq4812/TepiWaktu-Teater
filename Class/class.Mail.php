<?php
require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../inc.config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
	public static function SendMail($to, $name, $subject, $message)
	{
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";
		$mail->Host = app_config('smtp_host');
		$mail->Port = (int) app_config('smtp_port');
		$mail->Username = app_config('smtp_username');
		$mail->Password = app_config('smtp_password');
		$mail->From = app_config('smtp_from_email');
		$mail->FromName = app_config('smtp_from_name');
		$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
				));

		$mail->WordWrap = 50;
		$mail->isHTML(true);

		$mail->addAddress($to, $name);
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AltBody = strip_tags($message);

		$mail->SMTPDebug = 0;

		if (!$mail->send()) {
			// Lempar exception supaya pemanggil bisa menangani (bukan exit paksa)
			throw new Exception("Email gagal dikirim: " . $mail->ErrorInfo);
		}

		return true;
	}
}
