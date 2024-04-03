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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


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
            ->remove('emails') // Remove the emails field
            ->add('utilisateurs', CollectionType::class, [
                'entry_type' => UtilisateurType::class, // Assuming you have a UtilisateurType for rendering each player
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ]);
    
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
           
        ]);
    }
}
