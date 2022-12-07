<?php

namespace App\Controller;

use App\Entity\CourseCategory;
use App\Form\CourseCategoryType;
use App\Repository\CourseCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/course/category')]
class CourseCategoryController extends AbstractController
{
    #[Route('/', name: 'app_course_category_index', methods: ['GET'])]
    public function index(CourseCategoryRepository $courseCategoryRepository): Response
    {
        return $this->render('course_category/index.html.twig', [
            'course_categories' => $courseCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_course_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CourseCategoryRepository $courseCategoryRepository): Response
    {
        $courseCategory = new CourseCategory();
        $form = $this->createForm(CourseCategoryType::class, $courseCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseCategoryRepository->save($courseCategory, true);

            return $this->redirectToRoute('app_course_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('course_category/new.html.twig', [
            'course_category' => $courseCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_course_category_show', methods: ['GET'])]
    public function show(CourseCategory $courseCategory): Response
    {
        return $this->render('course_category/show.html.twig', [
            'course_category' => $courseCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_course_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CourseCategory $courseCategory, CourseCategoryRepository $courseCategoryRepository): Response
    {
        $form = $this->createForm(CourseCategoryType::class, $courseCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseCategoryRepository->save($courseCategory, true);

            return $this->redirectToRoute('app_course_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('course_category/edit.html.twig', [
            'course_category' => $courseCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_course_category_delete', methods: ['POST'])]
    public function delete(Request $request, CourseCategory $courseCategory, CourseCategoryRepository $courseCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$courseCategory->getId(), $request->request->get('_token'))) {
            $courseCategoryRepository->remove($courseCategory, true);
        }

        return $this->redirectToRoute('app_course_category_index', [], Response::HTTP_SEE_OTHER);
    }
}