<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Trainer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'datatable.name',
                'required' => true,
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'datatable.name',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'datatable.Email',
                'required' => true,
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'example@email.com',
                ]
            ])
            ->add('courses', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'required' => false,
                'multiple' => true,
                'label' => 'datatable.Courses',
                'label_attr' => [
                    'class' => 'form-label mt-3 fw-bold text-dark'
                ],
                'attr' => [
                    'class' => 'form-select ',
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainer::class,
        ]);
    }
}
