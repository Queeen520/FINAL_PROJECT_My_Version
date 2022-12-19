<?php
// src/Controller/ReviewController.php
namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;





// needed for file upload
use App\Service\FileUploader;

use App\Entity\CourseCategory;
use App\Form\CourseCategoryType;
use App\Repository\CourseCategoryRepository;
use App\Repository\PreBookingRepository;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/review')]
class ReviewController extends AbstractController
{
    #[Route('/{course_id}', name: 'app_review')]
    public function review(Request $request, $course_id, CourseRepository $courseRepository, PreBookingRepository $preBookingRepository): Response
    {

        
        
       # user must be logged in to write review
       $user = $this->getUser();
       
       if (!$user) {
        return $this->render('static/error.html.twig', [
            'error_message' => "error: must be logged in to write review ",
        ]);
    }
    
    
        # get course
        # check if course exists, if not redirect to error page
        $res = $courseRepository->findBy(['id' => $course_id]);
        if (!$res) {
            return $this->render('static/error.html.twig', [
                'error_message' => "wrong review url: course $course_id not found in database"
            ]);
        }
        $course = $res[0];
        
        
        $data = ['placeholder' => 'Type your message here',];
        $form = $this->createFormBuilder($data)
            ->add('message', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            
            
            # get prebooking
            #dd($course_id);
            #dd($user->getId());

            $res = $preBookingRepository->findBy(['fkCourse' => $course_id, 'fkUser' => $user->getId()]);
            $course_name = $course->getName();
            $course_date = $course->getStartTime()->format('Y-m-d g:i');
            $email=$user->getEmail();

            

            if (!$res) {
                 # no prebooking found, go to error page
                return $this->render('static/error.html.twig', [
                    'error_message' => "no booking found for course $course_name at $course_date for user $email"
                ]);
                }
            $pre_booking = $res[0];

            
            
            
           
            
            #$course = $res[0];
            # write review
            $pre_booking->setReview($data['message']);
            $preBookingRepository->save($pre_booking, true);

            dd($pre_booking);
            #dd($pre_booking);
            return $this->render('static/error.html.twig', [
                'error_message' => "Hello $email, you have successfully saved a review for course $course_name, held at $course_date!"
            ]);
            }

        

        

        
        # return form
        return $this->render('review/review.html.twig', [
            'reviewForm' => $form->createView(),
            'course_name'=>$course->getName(), 
            'course_date'=>$course->getStartTime()
        ]);
    }
    
}