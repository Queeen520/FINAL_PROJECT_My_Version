<?php

namespace App\Controller;

use App\Form\RegistrationFormWithoutLoginType;

use App\Entity\User;
use App\Entity\Course;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;

use App\Entity\PreBooking;
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
 public function register_no_login(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, CourseRepository $courseRepository): Response
 {
     $user = new User();
     
     $form = $this->createForm(RegistrationFormWithoutLoginType::class, $user);
     
     $form->handleRequest($request);
     
     if($form->isSubmitted() && !$form->isValid()){
        # user books a second course without login
        # so the email is already in the database and isValid is false
        # get email from form
        $email = $form->get('email')->getData();
        # check if that email is in the database
        $res = $userRepository->findBy(['email'=>$email]);
        if($res){
        # email exists already
        dd($res);
    };
        
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
        # store user details in databases
        $entityManager->persist($user);
        $entityManager->flush();
        # dd($passw);
        # set course booking for this course and this user

        # get course id
        
        $course_id = $request->query->get('id');
        $res = $courseRepository->findBy(['id'=>$course_id]);
        $course=$res[0];

        # $course= $request->query;

        # get user id
        $email = $form->get('email')->getData();
        $res = $userRepository->findBy(['email'=>$email]);
        $user_id = $res[0]->getId();
        $user = $res[0];
        # set number of participants to 1, this has to be changed for business users registering more participants
        $number_participants = 1;
        # 

        # write prebooking
        $pre_booking = new PreBooking();
        $pre_booking->setNumberParticipants($number_participants);
        $pre_booking->setFkCourse($course);
        $pre_booking->setFkUser($user);
        
        $entityManager->persist($pre_booking);
        $entityManager->flush();

        dd($_SESSION);
        
         # send email to user with course details (optionally login details)

        



         return $this->redirectToRoute('app_login');
     }
     

     return $this->render('registration/register_no_login.html.twig', [
         'registrationFormWithoutLogin' => $form->createView(),
     ]);
 }
}