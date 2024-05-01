<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use App\Form\UtilisateurType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\UtilisateurRepository;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('niveau')
            ->add('israndom')
            ->add('rank')
            ->add('idcateg', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
            ])
            ->add('utilisateurs', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom', // Change 'nom' to the property you want to display for Utilisateur
                'multiple' => true, // Allow selecting multiple Utilisateur entities
                'expanded' => true, // Display checkboxes instead of a dropdown
                'query_builder' => function(UtilisateurRepository $userRepository) {
                    return $userRepository->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC'); // Optionally, order Utilisateurs by name
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
            'users' => [],
        ]);
    }
}