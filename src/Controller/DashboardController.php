<?php

namespace App\Controller;


use App\Entity\PreBooking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $pre = $doctrine->getRepository(PreBooking::class)->findAll();

        //dd($pre);

        return $this->render('dashboard/index.html.twig', [
            'pre' => $pre
        ]);
    }
}
