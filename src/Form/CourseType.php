<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\CourseCategory;
use App\Entity\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


// used for foreign key 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime', DateTimeType::class, ["attr"=>["class"=>"form-control mb-2"]])
            ->add('endTime', DateTimeType::class, ["attr"=>["class"=>"form-control mb-2"]])
            // foreign key Category
            ->add('fkCourseCategory', EntityType::class,[
                "attr"=>["placeholder"=>"please type Category name", "class"=>"form-control mb-2"],
                'class'=>CourseCategory::class,
                'choice_label'=>'Name',
                'label'=>'Course Category'
            ])
            // foreign key Price
            ->add('fkPrice', EntityType::class,[
                "attr"=>["placeholder"=>"please type Price", "class"=>"form-control mb-2"],
                'class'=>Price::class,
                'choice_label'=>'name',
                'label'=>'Price'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
