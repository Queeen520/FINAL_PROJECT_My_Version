<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerController extends AbstractController
{
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('first-aid@eclipso.eu')
            ->to('first-aid-vienna@tutanota.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $errors='no errors';  
        $user= urlencode('first-aid@eclipso.eu');
        
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $errors=$e;            
        }
        
        
        return $this->render('mail/index.html.twig', [
            'message' => 'mail sent!',
            'errors' => $errors,
            'user'=>$user
            ]);

        // ...
    }
}