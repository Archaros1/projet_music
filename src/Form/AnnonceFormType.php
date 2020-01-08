<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Lieu;
use App\Entity\Style;
use App\Form\StyleFormType;
use App\Entity\EventType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class AnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_event')
            ->add('genre_event')
            ->add('date_begin' , DateTimeType::class)
            ->add('date_end', DateTimeType::class)
            ->add('description')
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'name'
            ])
            ->add('style_recherche', CollectionType::class, [
                'entry_type' => StyleFormType::class,
                'allow_add' => true,
                'label' => 'Style recherché'
            ])
            ->add('type_event', EntityType::class, [
                'class' => EventType::class,
                'choice_label' => 'name'
            ])
            // SUBMIT
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
