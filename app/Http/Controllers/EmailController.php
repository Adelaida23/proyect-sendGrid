<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Mail\TestEmail;
use Services\Factories\MailerFactory;

class EmailController extends Controller
{

    public function formEmail()
    {
        return view('formEmail');
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
        $listEmails   = explode("\n", $texto_emails);

        $sending = MailerFactory::create($platform);
        $sending->listEmails($listEmails);
        $sending->subject($subject);
        $sending->message($message);
        $sending->send();

        return redirect()->route('form.email');
    }

}
