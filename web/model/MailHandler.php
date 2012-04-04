<?php

class MailHandler
{
    /**
     * sending email with snippet
     */
    public function sendMail($to, $subject,$message)
    {
        mail($to, $subject,$message);
    }
}
