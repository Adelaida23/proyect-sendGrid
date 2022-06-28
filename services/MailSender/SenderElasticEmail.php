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
        $this->apiKey     = env('API_KEY_MAILGUN');
        $this->domain     = env('DOMAIN_NAME_MAILGUN');
    }

    public function listEmails( array $listEmails )
    {
        $this->listEmails = implode(',', $listEmails);
    }

    public function send()
    {

        $url = 'https://api.elasticemail.com/v2/email/send';

        try{
            $post = array('from' => $this->fromEmail,
                'fromName' => $this->fromName,
                'apikey' => '657DB740199661DFE08AFBD6107B5BA184C6AB4E8E3468C79CAAE1035FECE1275649648775268A7FE7729046C62FF3AF',
                'subject' => $this->subject,
                'to' => $this->listEmails,
                'bodyHtml' => '<h1>Html Body</h1>',
                'bodyText' => 'Text Body',
                'isTransactional' => false);

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $post,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $result=curl_exec ($ch);
            curl_close ($ch);
            dd($result);
            echo $result;
        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }

    }

}
/* API KEY
 * 657DB740199661DFE08AFBD6107B5BA184C6AB4E8E3468C79CAAE1035FECE1275649648775268A7FE7729046C62FF3AF
 */
