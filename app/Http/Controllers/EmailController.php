<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use SendGrid;
use SendGrid\Mail\Mail;
use App\Mail\TestEmail;

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

    public function sendWithSendGrid($listEmails,  $message)
    {
        $email = new Mail();
        $email->setFrom("contacto@sisadesel.com.mx", "Contacto sisadesel");
        $tos = $listEmails;
        $email->addTos($tos);
        $email->setSubject("ENVIO CORREO DE PRUEBA");
        //  $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        /*
        $email->addContent(
            "text/html",
            "<strong> Correo enviado de prueba. este correo se recibio correctamente</strong>"
        );
        */
        $email->addContent($message);
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

    public function getParams(Request $request)
    {
        $request->validate(
            [
                'correos' => 'required',
                'message' => 'required',
                'platform'  => 'required'
            ],
            [
                'correos.required' => 'You need add emails ',
                'message' => 'You nedd add messages to send',
                'platform' => 'You need select one platform'
            ]
        );
        $message = $request->message;
        $platform = $request->platform;
        $listEmails = null;
        $texto_emails = str_replace("\r", "",  str_replace(" ", "", $request->correos));
        $arg_emails =  explode("\n", $texto_emails);
        for ($i = 0; $i < count($arg_emails); $i++) {
            $listEmails[$arg_emails[$i]] = ""; //nombres vacios
        }
        return $platform;
        //$this->sendWithSendGrid($listEmails, $message, $platform);
    }
}
