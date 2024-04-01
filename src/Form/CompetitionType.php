<?php

namespace App\Form;

use App\Entity\Competition;
use Symfony\Component\Form\AbstractType;
use App\Entity\Terrain;
use App\Entity\Equipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type')
            ->add('date')
            ->add('heure')
            ->add('description')
            ->add('terrain', EntityType::class, [
                'class' => Terrain::class,
                'choice_label' => 'nom', // Assuming 'name' is the property you want to display in the dropdown
                'placeholder' => 'Choose a terrain', // Optional placeholder
            ])
            ->add('equipe1', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nom', // Assuming 'name' is the property you want to display in the dropdown
                'placeholder' => 'Choose an equipe', // Optional placeholder
            ])
            ->add('equipe2', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nom', // Assuming 'name' is the property you want to display in the dropdown
                'placeholder' => 'Choose an equipe', // Optional placeholder
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
        ]);
    }
}
