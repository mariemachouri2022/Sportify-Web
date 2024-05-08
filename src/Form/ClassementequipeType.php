<?php

namespace App\Form;

use App\Entity\Classementequipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassementequipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('points')
            ->add('rank')
            ->add('nbreDeMatch')
            ->add('win')
            ->add('draw')
            ->add('loss')
            ->add('equipeId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classementequipe::class,
        ]);
    }
}
