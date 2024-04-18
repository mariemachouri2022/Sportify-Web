<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Terrain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeure', DateTimeType::class, [
                'label' => 'Date and Time',
                'widget' => 'single_text',
                // Add more options if needed
            ])
            ->add('duree')
            ->add('idTerrain', EntityType::class, [
                'class' => Terrain::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choose a terrain',
                'attr' => [
                    'id' => 'reservation_idTerrain',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
