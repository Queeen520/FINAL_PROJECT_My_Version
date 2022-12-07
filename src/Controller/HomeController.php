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

        $course1 = $doctrine->getRepository(CourseCategory::class)->findBy(['id' => '1']);
        
        $course2 = $doctrine->getRepository(CourseCategory::class)->findBy(['id' => '2']);

        return $this->render('home/index.html.twig', [
            'course1' => $course1,
            'course2' => $course2
        ]);
    }
}
