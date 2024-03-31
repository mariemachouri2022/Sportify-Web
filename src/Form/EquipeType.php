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
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choices' => $options['users'], // Use the fetched users as choices
                'choice_label' => function ($user) {
                    // Customize how the users are displayed in the select field
                    return $user->getNom() . ' ' . $user->getPrenom(); // Display user's full name
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
