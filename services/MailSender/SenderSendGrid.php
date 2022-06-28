<?php

namespace Services\MailSender;

use SendGrid\Mail\Mail;
use Exception;
use SendGrid;

class SenderSendGrid extends MailSender
{

    protected $apiKey;

    protected $domain;

    public function __construct()
    {
        $this->init();
        $this->apiKey     = env('SENDGRID_API_KEY');
        $this->domain     = '';
    }

    public function listEmails( array $listEmails )
    {

        $emails = [];

        foreach($listEmails as $key => $email){

            $emails[$email] = "";

        }

        $this->listEmails = $emails;

    }

    public function send()
    {

        $email      = new Mail();
        $email->setFrom($this->fromEmail, $this->fromName);
        $email->addTos($this->listEmails);
        $email->setSubject($this->subject);
        $email->addContent("text/html", $this->message);

        $sendgrid = new \SendGrid($this->apiKey);

        try {

            $response = $sendgrid->send($email);

            return back()->with('success', "Send emails correctly \n");

        } catch (Exception $e) {

            return back()->with('error', "Error \n");
        }

    }

}
