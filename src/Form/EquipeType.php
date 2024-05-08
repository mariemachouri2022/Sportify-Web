<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Categorie;
use App\Entity\Utilisateurs; 
use Symfony\Component\Form\AbstractType;
use App\Form\UtilisateursType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\UtilisateursRepository;

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
                'class' => Utilisateurs::class, 
                'choice_label' => 'nom', 
                'multiple' => true, 
                'expanded' => true, 
                'query_builder' => function(UtilisateursRepository $userRepository) {
                    return $userRepository->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC'); 
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