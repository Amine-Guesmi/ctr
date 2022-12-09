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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UpdateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
                                "Admin" => "ROLE_ADMIN",
                                "Responsable Logistique" => "ROLE_RESPONSABLE_RH",
                                "Responsable Resources Humain" => "ROLE_RESPONSABLE_LOGISTIQUE",
                                "Responsable Stock" => "ROLE_RESPONSABLE_STOCK",
                            ]
                        ]
                    ]
                            ],['label' => false])
                ->add('adresse',null,['label' => false])
                ->add('tel',NumberType::class,['label' => false])
                ->add('image',FileType::class,array('data_class' => null,'required' => false,'mapped'=> false),['label' => false])
                ->add('cvFile',FileType::class,array('data_class' => null,'required' => false,'mapped'=> false),['label' => false])
                ->add('password',PasswordType::class,['label' => false])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
