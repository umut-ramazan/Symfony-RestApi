<?php

namespace App\Services;

use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\ExceptionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

 class EmailTransactions
 {
     /**
     *
     * @param  $data []
     * @return String
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function  EmailSend($data,MailerInterface $mailer): String
    {
        $email = (new Email())
            ->from($data['fromEmail'])
            ->to($data['toEmail'])
            ->subject($data['Subject'])
            ->html($data['html'])
        ;

        try
        {
            $mailer->send($email);

            return true;
        }
        catch (ExceptionInterface $e)
        {
            return $e->getMessage();
        }


    }


}