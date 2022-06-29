<?php

namespace Services\MailSender;

use Exception;

class SenderElasticEmail extends MailSender
{

    protected $apiKey;

    protected $domain;

    public function __construct()
    {
        $this->init();
        $this->apiKey     = env('API_KEY_ELASTICEMAIL');
        $this->domain     = env('DOMAIN_NAME_ELASTICEMAIL');
    }

    public function listEmails( array $listEmails )
    {
        $this->listEmails = implode(',', $listEmails);
    }

    public function send()
    {
        try{
            $mailClient = array(
                'from'            => $this->fromEmail,
                'fromName'        => $this->fromName,
                'apikey'          => $this->apiKey,
                'subject'         => $this->subject,
                'to'              => $this->listEmails,
                'bodyHtml'        => $this->message,
                'isTransactional' => false
            );

            $ch = curl_init();

            curl_setopt_array($ch, array(
                CURLOPT_URL            => $this->domain,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $mailClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $result=curl_exec ($ch);

            curl_close ($ch);

            return back()->with('success', "Send emails correctly \n");
        }
        catch(Exception $ex){
            echo $ex->getMessage();

            return back()->with('error', "Error \n");
        }

    }

}
