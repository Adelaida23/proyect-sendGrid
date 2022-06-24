<?php

use SendGrid\Mail\Mail;

abstract class MailSender
{
    public $subject = "";
    public $message = "";
    public $listEmails = [];
    public $platform  = "";

    /*
    public function getParam($message, $platform, $subject)
    {
    }
    */

    public function senderEmail($subject, $message, $listEmails)
    {
    }
}
/*
class ClaseSenderPlatform extends MailSender
{
    protected function getValor() {
        return "ClaseConcreta1";
    }

    public function valorPrefijo($prefijo) {
        return "{$prefijo}ClaseConcreta1";
    }

    public function senderEmail(){

    }
}
*/

class ClaseSenderGrid extends MailSender
{
    /*
    protected function getValor()
    {
        return "ClaseConcreta1";
    }

    public function valorPrefijo($prefijo)
    {
        return "{$prefijo}ClaseConcreta1";
    }
    */

    public function senderEmail($subject, $message, $listEmails)
    {
        
        $listEmails2 = null;
        for ($i = 0; $i < count($listEmails); $i++) {
            $listEmails2[$listEmails[$i]] = ""; //nombres vacios
        }
        $email = new Mail();
        $email->setFrom("contacto@sisadesel.com.mx", "Contacto sisadesel");
        $tos = $listEmails2;
        $email->addTos($tos);
        $email->setSubject($subject);
        $email->addContent("text/html", $message);
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            // return back()->with('success', "Send emails correctly \n". $response->statusCode() . "\n");
            return back()->with('success', "Send emails correctly \n"); // . $response->statusCode() . "\n");
        } catch (Exception $e) {
            //  return back()->with('error', 'Caught exception: ' .  $e-    >getMessage() . "\n");
            echo 'Caught exception: ' .  $e->getMessage() . "\n";
        }
    }
}

class ClaseMailGun extends MailSender
{
    /*
    protected function getValor() {
        return "ClaseConcreta1";
    }

    public function valorPrefijo($prefijo) {
        return "{$prefijo}ClaseConcreta1";
    }
    */

    public function senderEmail($subject, $message, $listEmails)
    {

        $mailClient = Mailgun::create(env('API_KEY_MAILGUN'));
        $domain     = env('DOMAIN_NAME_MAILGUN');
        $from_name  = env('MAIL_FROM_NAME');
        $from_email = env('MAIL_FROM_ADDRESS');

        $result = $mailClient->messages()->send($domain, [
            'from'      => $from_name . ' <' . $from_email . '>',
            'to'        => $listEmails,
            'subject'   => $subject,
            'html'      => $message
        ]);

        return true;
    }
}
