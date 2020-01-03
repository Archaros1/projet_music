<?php

namespace App\Form;

use App\Entity\Organisateur;
use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ACCOUNT data
            ->add('email')
            ->add('pw')
            // ORGA data
            ->add('name')
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
            'data_class' => Organisateur::class,
        ]);
    }
}
