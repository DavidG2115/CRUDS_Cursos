<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Employee;
use App\Entity\Trainer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Name',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true,
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ]
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Duration',
                'required' => true,
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Duration in Hours',
                ]
            ])
            ->add('employees', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'id',
                'label' => 'Employees',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-select',
                ]
            ])
            ->add('trainers', EntityType::class, [
                'class' => Trainer::class,
                'choice_label' => 'id',
                'label' => 'Trainers',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
