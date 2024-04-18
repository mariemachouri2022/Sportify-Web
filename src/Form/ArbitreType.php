<?php

namespace App\Form;

use App\Entity\Arbitre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ArbitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('nom', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 10]),
            ],
        ])
        ->add('prenom', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 10]),
            ],
        ])
        ->add('email', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Length(['max' => 50]),
            ],
        ])
        ->add('phone', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex(['pattern' => '/^\d{8}$/']),
            ],
        ])
    ;
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Arbitre::class,
        ]);
    }
}
