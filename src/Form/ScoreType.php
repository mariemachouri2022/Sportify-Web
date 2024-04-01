<?php

namespace App\Form;

use App\Entity\Competition;
use App\Entity\Score;
use App\Entity\Equipe;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\NotBlank;


class ScoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipe1score',null,[
                'constraints' => [
                new NotBlank(),
                new PositiveOrZero(),
            ],
        ])
            ->add('equipe2score' ,null,[
                'constraints' => [
                new NotBlank(),
                new PositiveOrZero(),
            ],
        ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Score::class,
        ]);
    }
}
