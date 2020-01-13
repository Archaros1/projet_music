<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\Style;
use App\Entity\GroupeType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GroupeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('nombre_membre')
            ->add('description')
            ->add('a_domicile')
            ->add('a_tout_son_materiel')
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
            ->add('type', EntityType::class, [
                'class' => GroupeType::class,
                'choice_label' => 'name'
            ])
            // SUBMIT
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
