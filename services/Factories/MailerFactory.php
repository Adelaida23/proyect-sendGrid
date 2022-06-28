<?php

namespace Services\Factories;

use Services\MailSender\SenderMailGun;
use Services\MailSender\SenderSendGrid;
use Services\MailSender\SenderElasticEmail;

class MailerFactory
{

    public static function create( $platform )
    {

        $sending = '';

        if( $platform == 'mailGun' )
        {

            $sending = new SenderMailGun();

        }

        if( $platform == 'sendGrid' )
        {

            $sending = new SenderSendGrid();

        }

        if( $platform == 'elasticEmail' )
        {

            $sending = new SenderElasticEmail();

        }

        return $sending;
    }

}
