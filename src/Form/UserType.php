<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',null,['label' => false])
            ->add('prenom',null,['label' => false])
            ->add('email',null,['label' => false])
            ->add('roles',CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'choices' => [
                        "Roles" => [
                            "Admin" => "Admin",
                            "Responsable Logistique" => "Responsable Logistique",
                            "Responsable Resources Humain" => "Responsable Resources Humain",
                            "Responsable Stock" => "Responsable Stock",
                        ]
                    ]
                ]
                        ],['label' => false])
            ->add('password',null,['label' => false])
            ->add('adresse',null,['label' => false])
            ->add('tel',NumberType::class,['label' => false])
            ->add('image',FileType::class,['label' => false])
            ->add('cvFile',FileType::class,['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
