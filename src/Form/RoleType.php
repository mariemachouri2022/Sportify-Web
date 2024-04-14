<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('role', ChoiceType::class, [
            'choices' => [
                'USER' => 'USER',
                'PROPRIETAIRE' => 'PROPRIETAIRE',
                'ADMIN' => 'ADMIN',
               
            ],
            'placeholder' => 'Role',
            'constraints' => [
                new NotBlank(['message' => 'Please select your preferred role']),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Set the data class to null since this form doesn't map to an entity
            'data_class' => null,
        ]);
    }
}
