<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/trainer')]
class TrainerController extends AbstractController
{
    #[Route('/index', name: 'trainer_dashboard_xx')]
    public function index2(): Response
    {
        return $this->render('trainer/index.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }
  

    #[Route('/', name: 'trainer_dashboard')]
    public function index(UserRepository $userRepository): Response
    {
        # get trainers
        $users = $userRepository->findAll();
        $trainers = array_filter($users, function ($user) {return in_array('ROLE_TRAINER', $user->getRoles());});
          
        #dd($trainers);
        
        return $this->render('trainer/index.html.twig', [
            'trainers' => $trainers,
        ]);
    }

    #[Route('/profile/{id}', name: 'app_profile_trainer')]
    public function profile(ManagerRegistry $doctrine, UserRepository $userRepository, $id): Response
    {
        $trainer = $userRepository->find($id);

        return $this->render('trainer/show.html.twig', [
            'trainer' => $trainer,
        ]);
    }

}
