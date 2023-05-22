<?php

namespace App\Form;

use App\Entity\Recettes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('tpsPreparation')
            ->add('tpsCuisson')
            ->add('tpsRepos')
            ->add('preparation')
            ->add('photo')
            ->add('saison')
            ->add('nbPersonnes')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
        ]);
    }
}
