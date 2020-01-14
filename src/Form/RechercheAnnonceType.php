<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Style;
use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;




class RechercheAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('lieu', EntityType::class, [
            'class' => Lieu::class,
            'choice_label' => 'name'
        ])
        ->add('style_recherche', EntityType::class, [
            'class' => Style::class,
            'choice_label' => 'name',
            'multiple' => true,
            // 'mapped' => false,
            'expanded' => true,
            'label' => 'Style(s) recherché(s)',
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
            'data_class' => Annonce::class,
        ]);
    }
}
