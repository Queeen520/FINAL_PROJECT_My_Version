<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

// needed for file upload
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fname', TextType::class, ["attr" => ['class' => 'form-control my-2', 'placeholder' => 'Please enter your First Name'], 'required' => false])
            ->add('lname', TextType::class, ["attr" => ['class' => 'form-control my-2 ', 'placeholder' => 'Please enter your Last Name'], 'required' => false])
            ->add('email', TextType::class, ["attr" => ['class' => 'form-control my-2 ', 'placeholder' => 'Please enter your Email'], 'required' => false])
            ->add('address', TextType::class, ["attr" => ['class' => 'form-control my-2 ', 'placeholder' => 'Please enter your Address (City, Street, Number)'], 'required' => false])
            //build the form using the file type input
            ->add('image', FileType::class, [
                'attr' => ["class"=>"form-control mb-2"],
                'label' => 'Upload Picture',
            //unmapped means that is not associated to any entity property
                'mapped' => false,
            //not mandatory to have a file
                'required' => false,
            //in the associated entity, so you can use the PHP constraint classes as validators
                'constraints' => [
                    new File([
                        'maxSize' => '3024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ]
            ])
           
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control my-2 w-100', 'autocomplete' => 'new-password', 'placeholder' => 'Please enter your password'],
                'constraints' => [
                   
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
