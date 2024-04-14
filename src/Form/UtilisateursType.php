<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('prenom', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ]) 
        ->add('email', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('adresse', null, [
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('image', FileType::class, [
            'label' => 'Image (JPG file)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'mimeTypesMessage' => 'Please upload a valid JPG document',
                ])
            ],
        ])
        ->add('date_de_naissance', DateType::class, [
            'widget' => 'single_text',
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('role', ChoiceType::class, [
            'choices' => [
                'USER' => 'USER',
                'PROPRIETAIRE' => 'PROPRIETAIRE',
            ],
            'constraints' => [
                new NotBlank(),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
