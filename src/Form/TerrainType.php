<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Terrain;
use App\Form\TerrainType;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('typeSurface')
            ->add('localisation')
            ->add('prix')
            ->add('imageTer', FileType::class, [
                'label' => 'Image',
                'required' => false, // Make the image field not required
                'mapped' => false, // Tell Symfony not to map this field to any property on the entity
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
