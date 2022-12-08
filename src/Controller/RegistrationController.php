<?php

namespace App\Controller;

use App\Form\RegistrationFormWithoutLoginType;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

 #[Route('/register_no_login', name: 'app_register_no_login')]
 public function register_no_login(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
 {
     $user = new User();
     
     $form = $this->createForm(RegistrationFormWithoutLoginType::class, $user);
     
     $form->handleRequest($request);
     
     if($form->isSubmitted() && !$form->isValid()){
         # user books a second course without login
         $email = $form->get('email')->getData();
         $query = "SELECT * from something complicated";
         #$rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($query); 
         if ($form->get('email')){
         dd($form->get('email')->getData());#->getViewData);
         }
         else{
         dd($user);  
         }
     }

     if ($form->isSubmitted() && $form->isValid()) {
         # use random password since the user does not login and therefore doesnt provide a password
         $passw = bin2hex(openssl_random_pseudo_bytes(4));
         $user->setPassword(
             $userPasswordHasher->hashPassword(
                 $user,
                 $passw
             )
         );
         $entityManager->persist($user);
         $entityManager->flush();
         # dd($passw);
         // do anything else you need here, like send an email



         return $this->redirectToRoute('app_login');
     }
     

     return $this->render('registration/register_no_login.html.twig', [
         'registrationFormWithoutLogin' => $form->createView(),
     ]);
 }
}