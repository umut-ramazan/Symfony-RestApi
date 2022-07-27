<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\EmailTransactions;

class EmailController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/email', name: 'app_email')]
    public function index(EmailTransactions $emailTransactions,Request $request): Response
    {

        $deger= $emailTransactions->EmailSend($request->toArray());

        if (!$deger){
            return new Response("Email Gönderilmedi");
        }

        return new Response("Email Gönderildi");



    }
}
