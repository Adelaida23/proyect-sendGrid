<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use SendGrid;
use SendGrid\Mail\Mail;
use App\Mail\TestEmail;
use Mailgun\Mailgun;

class EmailController extends Controller
{
    public function formEmail()
    {
        return view('formEmail');
    }

    public function send(Request $request)
    {

        $email = new Mail();
        $email->setFrom("contacto@sisadesel.com.mx");
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
    }

    public function sendMultiple($arg)
    {
        $email = new Mail();
        $email->setFrom("contacto@sisadesel.com.mx", "Contacto sisadesel");
        $tos = $arg;
        /*
        $tos = [
            "adhel1997@gmail.com" => "Adelaida Molina",
            "adelaida.molinar1997@gmail.com" => "adheel",
            "hzhm1997@gmail.com" => "Heber Zabdiel"
        ];*/
        $email->addTos($tos);
        $email->setSubject("ENVIO CORREO DE PRUEBA");
        //  $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html",
            "<strong> Correo enviado de prueba. este correo se recibio correctamente</strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
         //   $response = $sendgrid->send
            $response = $sendgrid->send($email); 
            // return back()->with('success', "Send emails correctly \n". $response->statusCode() . "\n");
            return back()->with('success', "Send emails correctly \n"); // . $response->statusCode() . "\n");
            //  print $response->statusCode() . "\n";
            //  print_r($response->headers());
            //  print $response->body() . "\n";
        } catch (Exception $e) {
            return back()->with('error', 'Caught exception: ' .  $e->getMessage() . "\n");
            //  echo 'Caught exception: ' .  $e->getMessage() . "\n";
        }
    }

    public function getEmails(Request $request)
    {
        $request->validate(
            [
                'correos' => 'required',
            ],
            ['correos.required' => 'You need add emails ']
        );
        //revisar codigo ascii mac, en windows "\n" 
        //method trim() php online quiet end  and start spacie 
        $arg_final = null;
        $texto_emails = str_replace("\r", "",  str_replace(" ", "", $request->correos));
        $arg_emails =  explode("\n", $texto_emails);
        for ($i = 0; $i < count($arg_emails); $i++) {
            $arg_final[$arg_emails[$i]] = ""; //nombres vacios
        }
        // return $arg_final;
        $this->sendMultiple($arg_final);
    }

    public function sendMails(Request $request)
    {
        $listEmails = [
            'chessed03@gmail.com',
            'worktestmail00@gmail.com'
        ];
        $message    = '<b>Code HTML!</b><h5>Cabecera de tipo H5</h5><h6>Cabecera de tipo H6</h6>';
        $subject    = 'Test Mailgun version 2';
        $platform   = 'mailGun';

        $this->mailSender( $platform, $message, $subject, $listEmails );
    }

    public function mailSender( $platform, $message, $subject, $listEmails )
    {

        if ( $platform ==  'mailGun' ){

            $this->sendMailGun( $subject, $message, $listEmails );

            return true;
        }

    }

    public function sendMailGun( $subject, $message, $listEmails )
    {
        $mailClient = Mailgun::create(env('API_KEY_MAILGUN'));
        $domain     = env('DOMAIN_NAME_MAILGUN');
        $from_name  = env('MAIL_FROM_NAME');
        $from_email = env('MAIL_FROM_ADDRESS');

        $result = $mailClient->messages()->send($domain, [
            'from'	  => $from_name.' <'.$from_email.'>',
            'to'	  => $listEmails,
            'subject' => $subject,
            'html'	  => $message
        ]);

        return true;
    }

}
