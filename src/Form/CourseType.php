<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\CourseCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

// used for foreign key 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime')
            ->add('endTime')
            // foreign key
            ->add('fkCourseCategory', EntityType::class,[
                "attr"=>["placeholder"=>"please type Category name", "class"=>"form-control mb-2"],
                'class'=>CourseCategory::class,
                'choice_label'=>'name',
                'label'=>'CourseCategory'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
