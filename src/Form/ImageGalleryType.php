<?php

namespace App\Form;
use App\Entity\Course;
use App\Entity\ImageGallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// needed for foreign key
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

// needed for file upload
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ImageGalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        
        $builder
            ->add('description', TextareaType::class, ['attr' => ['class' => 'form-control mb-2']])
            
            //build the form using the file type input
            ->add('image', FileType::class, [
                'attr' => ['class' => 'form-control mb-2'],
                'label' => 'Upload Picture',
            //unmapped means that is not associated to any entity property
                'mapped' => false,
            //not mandatory to have a file
                'required' => false,

            //file uploader
            //in the associated entity, so you can use the PHP constraint classes as validators
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ]
            ])
            ->add('fkCourse', EntityType::class,[
                "attr"=>["placeholder"=>"please type Course name", "class"=>"form-control mb-2"],
                'class'=>Course::class,
 				# Course needs a name field
                'choice_label'=>'FkCourseCategory.name', #FkCourseCategory().name',
                'label'=>'Course'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImageGallery::class,
        ]);
    }
}
