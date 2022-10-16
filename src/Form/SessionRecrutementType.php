<?php

namespace App\Form;

use App\Entity\SessionRecrutement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class SessionRecrutementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSession', null ,['attr' => ["class" => "form-control", "placeholder" => "Nom du Session... "],'error_bubbling' => true, "label" => false])
            ->add('description', null ,['attr' => ["class" => "form-control", "placeholder" => "Description... "],'error_bubbling' => true, "label" => false])
            ->add('active', null ,['attr' => ["class" => "form-control", "placeholder" => false],'error_bubbling' => true, "label" => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SessionRecrutement::class,
        ]);
    }
}
