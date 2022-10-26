<?php

namespace App\Form;

use App\Entity\Employer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',null,['label' => false])
            ->add('prenom',null,['label' => false])
            ->add('dateNais',null,['label' => false])
            ->add('Image',FileType::class,array('data_class' => null,'required' => false),['label' => false])
            ->add('tel',null,['label' => false])
            ->add('email',null,['label' => false])
            ->add('adresse',null,['label' => false])
            ->add('salaire',null,['label' => false])
            ->add('cv',FileType::class,array('data_class' => null,'required' => false),['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employer::class,
        ]);
    }
}
