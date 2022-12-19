<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

use App\Form\RegistrationFormWithoutLoginType;

use App\Entity\User;
use App\Entity\Course;

use App\Repository\CourseRepository;

use App\Entity\PreBooking;
use App\Form\RegistrationFormType;
use App\Form\EditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

// needed for file upload
use App\Service\FileUploader;


#[Route('/')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        
        //  dd($_SESSION);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user_id' => ''
        ]);
    }

    #[Route('/profile', name: 'app_profile_user')]
    public function profile(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/edit/{user_id}', name: 'app_edit_user')]
    public function edit($user_id, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $user = $userRepository->findBy(['id'=>$user_id]);
        if(!$user){
            return $this->render('static/error.html.twig', [
                'error_message' => "user $user_id not found in database",
            ]); 
        }
        $user=$user[0];
        $form = $this->createForm(EditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            if ($form->get('plainPassword')->getData()) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            # ************************** File Uploader Code ******************************
            $pictureFile = $form->get('image')->getData();
            //pictureUrl is the name given to the input field
            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $user->setImage($pictureFileName);
            }
            # *****************************************************************************
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/edit.html.twig', [
            'EditForm' => $form->createView(),
        ]);
        
        
    }
}
