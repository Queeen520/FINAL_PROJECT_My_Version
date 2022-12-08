<?php

namespace App\Controller;

use App\Entity\PreBooking;
use App\Form\PreBookingType;
use App\Repository\PreBookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pre/booking')]
class PreBookingController extends AbstractController
{
    #[Route('/', name: 'app_pre_booking_index', methods: ['GET'])]
    public function index(PreBookingRepository $preBookingRepository): Response
    {
        return $this->render('pre_booking/index.html.twig', [
            'pre_bookings' => $preBookingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pre_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PreBookingRepository $preBookingRepository): Response
    {
        $preBooking = new PreBooking();
        $form = $this->createForm(PreBookingType::class, $preBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preBookingRepository->save($preBooking, true);

            return $this->redirectToRoute('app_pre_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pre_booking/new.html.twig', [
            'pre_booking' => $preBooking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pre_booking_show', methods: ['GET'])]
    public function show(PreBooking $preBooking): Response
    {
        return $this->render('pre_booking/show.html.twig', [
            'pre_booking' => $preBooking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pre_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PreBooking $preBooking, PreBookingRepository $preBookingRepository): Response
    {
        $form = $this->createForm(PreBookingType::class, $preBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preBookingRepository->save($preBooking, true);

            return $this->redirectToRoute('app_pre_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pre_booking/edit.html.twig', [
            'pre_booking' => $preBooking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pre_booking_delete', methods: ['POST'])]
    public function delete(Request $request, PreBooking $preBooking, PreBookingRepository $preBookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$preBooking->getId(), $request->request->get('_token'))) {
            $preBookingRepository->remove($preBooking, true);
        }

        return $this->redirectToRoute('app_pre_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
