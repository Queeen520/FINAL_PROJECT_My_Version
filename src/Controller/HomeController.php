<?php

namespace App\Controller;
use App\Entity\CourseCategory;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $coursecategories = $doctrine->getRepository(CourseCategory::class)->findAll();
        

        return $this->render('home/index.html.twig', [
            'coursecategories' => $coursecategories,
        ]);
    }
}
