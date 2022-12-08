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

class RegistrationFormWithoutLoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fname', TextType::class, ["attr" => ['class' => 'form-control my-2 w-100', 'placeholder' => 'Please enter your given name'] ])           
            ->add('lname', TextType::class, ["attr" => ['class' => 'form-control my-2 w-100', 'placeholder' => 'Please enter your surname'] ])           
            ->add('email', TextType::class, ["attr" => ['class' => 'form-control my-2 w-100', 'placeholder' => 'Please enter your email'] ])
            ->add('address', TextType::class, ["attr" => ['class' => 'form-control my-2 w-100', 'placeholder' => 'Please enter your address (City, Street, Number)'] ])
            ->add('agreeTerms', CheckboxType::class, ['attr' => ['class' => 'd-flex flex-row align-items-center my-0'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }   
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
