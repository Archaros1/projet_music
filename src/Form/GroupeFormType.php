<?php

namespace App\Form;

use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ACCOUNT data
            ->add('email')
            ->add('pw')
            // GROUPE data
            ->add('name')
            ->add('nombre_membre')
            ->add('description')
            ->add('a_domicile')
            ->add('a_tout_son_materiel')
            ->add('style', EntityType::class, [
                'class' => Style::class,
                'choice_label' => 'Style'
            ])
            ->add('type', EntityType::class, [
                'class' => OrganisateurType::class,
                'choice_label' => 'Type'
            ])
            // CONTACT data
            ->add('phone')
            ->add('website')
            ->add('twitter')
            ->add('fb')
            // SUBMIT
            ->add('inscrire', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
