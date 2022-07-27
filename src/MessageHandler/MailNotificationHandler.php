<?php

namespace App\MessageHandler;

use App\Message\MailNotification;
use Symfony\Component\Mailer\Exception\ExceptionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class MailNotificationHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(MailNotification $message): void
    {
        $email = (new Email())
            ->from($message->getFrom())
            ->to('admin@admin.com')
            ->subject('New Incident #' . $message->getDescription())
            ->html('<p>' . $message->getDescription() . '</p>');

        try
        {
            $this->mailer->send($email);
            dump("Gönderildi");
        }
        catch (ExceptionInterface $e)
        {
            dump("Hata var".$e->getMessage());
        }
    }
}
