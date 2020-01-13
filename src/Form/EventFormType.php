<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Lieu;
use App\Entity\Style;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('date_begin' , DateTimeType::class)
            ->add('date_end', DateTimeType::class)
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'name'
            ])
            ->add('style', EntityType::class, [
                'class' => Style::class,
                'choice_label' => 'name',
                'multiple' => true,
                // 'mapped' => false,
                'expanded' => true,
                'label' => 'Style(s)',
                'choice_attr' => function() {
                    return ['class' => 'ml-2 mr-1'];
                },
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
