<?php

namespace App\Form;

use App\Entity\Competition;
use Symfony\Component\Form\AbstractType;
use App\Entity\Terrain;
use App\Entity\Equipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;





class CompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'TEAM' => 'TEAM',
                    'SOLO' => 'SOLO',
                ],
                'placeholder' => 'Choose type', // Optional placeholder
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new GreaterThanOrEqual('today') // Restrict to today and future dates
                ],
            ])
            ->add('heure', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('terrain', EntityType::class, [
                'class' => Terrain::class,
                'choice_label' => 'nom', // Assuming 'name' is the property you want to display in the dropdown
                'placeholder' => 'Choose a terrain', // Optional placeholder
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
        ]);
    }
}
