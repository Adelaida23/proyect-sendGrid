<?php

namespace Services\MailSender;

abstract class MailSender
{

    protected $apiKey;

    protected $domain;

    protected $fromName;

    protected $fromEmail;

    protected $message;

    protected $subject;

    protected $listEmails;

    public function init()
    {
        $this->fromName  = env('MAIL_FROM_NAME');
        $this->fromEmail = env('MAIL_FROM_ADDRESS');
    }

    public function apiKey( $apiKey )
    {
        $this->apiKey = $apiKey;
    }

    public function domain( $domain )
    {
        $this->domain = $domain;
    }

    public function message( $message )
    {
        $this->message = $message;
    }

    public function subject( $subject )
    {
        $this->subject = $subject;
    }

    public abstract function listEmails( array $listEmails );

    public abstract function send();

}
