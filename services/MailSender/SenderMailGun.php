<?php

namespace Services\MailSender;

use Mailgun\Mailgun;
use Exception;

class SenderMailGun extends MailSender
{

    protected $apiKey;

    protected $domain;

    public function __construct()
    {
        $this->init();
        $this->apiKey     = env('API_KEY_MAILGUN');
        $this->domain     = env('DOMAIN_NAME_MAILGUN');
    }

    public function listEmails( array $listEmails )
    {
        $this->listEmails = $listEmails;
    }

    public function send()
    {
        $mailClient = Mailgun::create( $this->apiKey );

        try {

            $response = $mailClient->messages()->send( $this->domain, [
                'from'	  => $this->fromName.' <' . $this->fromEmail . '>',
                'to'	  => $this->listEmails,
                'subject' => $this->subject,
                'html'	  => $this->message
            ]);

            return back()->with('success', "Send emails correctly \n");

        } catch (Exception $e) {

            return back()->with('error', "Error \n");

        }

    }

}
