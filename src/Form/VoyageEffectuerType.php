<?php

namespace App\Form;

use App\Entity\VoyageEffectuer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageEffectuerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pointDebut',null,['label' => false])
            ->add('dateDebut',null,['label' => false])
            ->add('pointFinale',null,['label' => false])
            ->add('dateFinale',null,['label' => false])
            ->add('Chauffeur',null,['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VoyageEffectuer::class,
        ]);
    }
}
