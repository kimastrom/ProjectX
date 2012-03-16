<?php

$mail = $_POST['mail'];
$subject = $_POST['subject'];
$text = $_POST['text'];

$to = $mail;
$message =" You received  a mail from ".$mail;
$message .=" Text of the message : ".$text;

if(mail($to, $subject,$message)){
	echo "mail successful send";
} 
else{ 
	echo "there's some errors to send the mail, verify your server options";
}