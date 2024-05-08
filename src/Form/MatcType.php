<?php

namespace App\Form;

use App\Entity\Arbitre;
use App\Entity\Equipe;
use App\Entity\Matc;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;

class MatcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $dateActuelle = new \DateTime();

// Obtenez la date dans 15 jours
$dateDans15Jours = (new \DateTime())->modify('+15 days');

        
        
        $builder
        ->add('nom', null, [
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 3,
                    'max' => 10,
                    'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('type', ChoiceType::class, [
            'choices' => [
                'Normal' => 'Normal',
                'Custom' => 'Custom',
                'Ranked' => 'Ranked',
            ],
            'constraints' => [
                new NotBlank(),
                new Choice([
                    'choices' => ['Normal', 'Custom', 'Ranked'],
                    'message' => 'Please choose a valid type.', // Message à afficher en cas d'erreur
                ]),
            ],
        ])
        ->add('date', DateType::class, [
            'widget' => 'single_text',
            'constraints' => [
                new NotBlank(),
                new GreaterThan([
                    'value' => $dateActuelle,
                    'message' => 'La date doit être postérieure à aujourd\'hui.',
                ]),
                new LessThan([
                    'value' => $dateDans15Jours,
                    'message' => 'La date ne peut pas dépasser 15 jours à partir d\'aujourd\'hui.',
                ]),
            ],
        ])
        ->add('heure', TimeType::class, [
            'widget' => 'single_text',
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('description', null, [
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 10,
                    'max' => 30,
                    'minMessage' => 'La description doit contenir au moins {{ limit }} caractères.',
                    'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('Equipe1', EntityType::class, [
            'class' => Equipe::class,
            'choice_label' => 'nom',
            'placeholder' => 'choisir une equipe',
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('Equipe2', EntityType::class, [
            'class' => Equipe::class,
            'choice_label' => 'nom',
            'placeholder' => 'Choisir une equipe',
            'constraints' => [
                new NotBlank(),
                
            ],
        ])
        ->add('arbitre', EntityType::class, [
            'class' => Arbitre::class,
            'choice_label' => 'nom',
            'placeholder' => 'choisir un arbitre',
            'constraints' => [
                new NotBlank(),
            ],
        ])
        #->add('captcha', Recaptcha3Type::class, [
         #   'constraints' => new Recaptcha3(),
          #  'action_name' => 'homepage',
            
        #])
        ->add('selectedCity', ChoiceType::class, [
            'choices' => [
                // Liste des 24 gouvernorats de Tunis
                'Ariana' => 'Ariana',
                'Beja' => 'Beja',
                'Ben Arous' => 'Ben Arous',
                'Bizerte' => 'Bizerte',
                'Gabes' => 'Gabes',
                'Gafsa' => 'Gafsa',
                'Jendouba' => 'Jendouba',
                'Kairouan' => 'Kairouan',
                'Kasserine' => 'Kasserine',
                'Kebili' => 'Kebili',
                'Kef' => 'Kef',
                'Mahdia' => 'Mahdia',
                'Manouba' => 'Manouba',
                'Medenine' => 'Medenine',
                'Monastir' => 'Monastir',
                'Nabeul' => 'Nabeul',
                'Sfax' => 'Sfax',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Siliana' => 'Siliana',
                'Sousse' => 'Sousse',
                'Tataouine' => 'Tataouine',
                'Tozeur' => 'Tozeur',
                'Tunis' => 'Tunis',
                'Zaghouan' => 'Zaghouan',
            ],
            'placeholder' => 'Sélectionnez une ville',
            'required' => true,
            'mapped' => false,

        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matc::class,
        ]);
    }
}
