<?php

namespace App\Controller;

// needed for file upload
use App\Service\FileUploader;

use App\Entity\ImageGallery;
use App\Form\ImageGalleryType;
use App\Repository\ImageGalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image/gallery')]
class ImageGalleryController extends AbstractController
{
    #[Route('/', name: 'app_image_gallery_index', methods: ['GET'])]
    public function index(ImageGalleryRepository $imageGalleryRepository): Response
    {
        return $this->render('image_gallery/index.html.twig', [
            'image_galleries' => $imageGalleryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_image_gallery_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImageGalleryRepository $imageGalleryRepository, FileUploader $fileUploader): Response
    {
        $imageGallery = new ImageGallery();
        $form = $this->createForm(ImageGalleryType::class, $imageGallery);
        $form->handleRequest($request);

        // ************************** File Uploader Code ******************************

        $pictureFile = $form->get('image')->getData();
        //pictureUrl is the name given to the input field
        if ($pictureFile) {
            $pictureFileName = $fileUploader->upload($pictureFile);
            $imageGallery->setImage($pictureFileName);
        }

        // *****************************************************************************

        if ($form->isSubmitted() && $form->isValid()) {
            $imageGalleryRepository->save($imageGallery, true);

            return $this->redirectToRoute('app_image_gallery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image_gallery/new.html.twig', [
            'image_gallery' => $imageGallery,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_gallery_show', methods: ['GET'])]
    public function show(ImageGallery $imageGallery): Response
    {
        return $this->render('image_gallery/show.html.twig', [
            'image_gallery' => $imageGallery,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_gallery_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageGallery $imageGallery, ImageGalleryRepository $imageGalleryRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ImageGalleryType::class, $imageGallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ************************** File Uploader Code ******************************
            
            $pictureFile = $form->get('image')->getData();
            
            //pictureUrl is the name given to the input field
            if ($pictureFile) {
                // check if existing image is not null and file exists
                if($imageGallery->getImage() && file_exists('pictures/'.$imageGallery->getImage())){
                unlink('pictures/'.$imageGallery->getImage());
                }
                $pictureFileName = $fileUploader->upload($pictureFile);
                $imageGallery->setImage($pictureFileName);
            }
            // *****************************************************************************

            $imageGalleryRepository->save($imageGallery, true);

            return $this->redirectToRoute('app_image_gallery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image_gallery/edit.html.twig', [
            'image_gallery' => $imageGallery,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_gallery_delete', methods: ['POST'])]
    public function delete(Request $request, ImageGallery $imageGallery, ImageGalleryRepository $imageGalleryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageGallery->getId(), $request->request->get('_token'))) {
            $imageGalleryRepository->remove($imageGallery, true);
        }

        return $this->redirectToRoute('app_image_gallery_index', [], Response::HTTP_SEE_OTHER);
    }
}
