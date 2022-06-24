<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use SendGrid;
use SendGrid\Mail\Mail;
use App\Mail\TestEmail;
use ClaseMailGun;
use ClaseSenderGrid;
use Mailgun\Mailgun;
use MailSender;

class EmailController extends Controller
{
    public function formEmail()
    {
        return view('formEmail');
    }
    /*
    public function send(Request $request)
    {
        $email = new Mail();
        //$email->setFrom("contacto@sisadesel.com.mx");
        $email->setFrom(env('MAIL_FROM_NAME'));
      //  $from_email = env('MAIL_FROM_ADDRESS');
        $email->setSubject("Sending with Twilio SendGrid is Fun"); //asucto email
        $email->addTo("adhel1997@gmail.com", "Example User"); //receptor: first: email, second: name
        //$email->addContent("text/plain", "and easy to do anywhere, even with PHP"); // message second param
        $email->addContent( //contenido email
            "text/html",
            "<strong>and easy to do anywhere, even with PHP</strong>"
        );

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' .  $e->getMessage() . "\n";
        }
    }*/

    public function sendWithSendGrid($subject, $message,  $listEmails)
    {
        $listEmails2 = null;
        for ($i = 0; $i < count($listEmails); $i++) {
            $listEmails2[$listEmails[$i]] = ""; //nombres vacios
        }
        $email = new Mail();
        $email->setFrom("contacto@sisadesel.com.mx", "Contacto sisadesel");
        // $email->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        // $tos = $listEmails;
        $tos = $listEmails2;
        $email->addTos($tos);
        $email->setSubject($subject);
        //  $email->addContent("text/plain", "and easy to do anywhere, even with PHP");

        /*
        $email->addContent(
            "text/html",
            "<strong> Correo enviado de prueba. este correo se recibio correctamente</strong>"
        );
        */

        $email->addContent("text/html", $message);
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            //   $response = $sendgrid->send

            $response = $sendgrid->send($email);
            // return back()->with('success', "Send emails correctly \n". $response->statusCode() . "\n");
            return back()->with('success', "Send emails correctly \n"); // . $response->statusCode() . "\n");
            //print $response->statusCode() . "\n";
            //print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            //  return back()->with('error', 'Caught exception: ' .  $e-    >getMessage() . "\n");
            echo 'Caught exception: ' .  $e->getMessage() . "\n";
        }
    }

    public function getParams(Request $request)
    {
        $request->validate(
            [
                'correos'  => 'required',
                'message'  => 'required',
                'platform' => 'required',
                'subject'  => 'required'
            ],
            [
                'correos.required' => 'You need add emails ',
                'message'          => 'You need add messages to send',
                'platform'         => 'You need select one platform',
                'subject'          => 'You need add the subject'
            ]
        );
        $message      = $request->message;
        $platform     = $request->platform;
        $subject      = $request->subject;
        $texto_emails = str_replace("\r", "",  str_replace(" ", "", $request->correos));
        $listEmails   =  explode("\n", $texto_emails);

        if ($platform ==  1) {
          //  $mail_sendr = new MailSender();
            $obj = new ClaseSenderGrid();
            $obj->senderEmail($subject, $message,  $listEmails);
            // $this->sendWithSendGrid($subject, $message,  $listEmails);
        }
        if ($platform ==  2) {
            $obj2 = new ClaseMailGun();
            $obj2->senderEmail($subject, $message,  $listEmails);

           // $this->sendMailGun($subject, $message, $listEmails);
        }

        return redirect()->route('form.email');
    }

    public function sendMailGun($subject, $message, $listEmails)
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
