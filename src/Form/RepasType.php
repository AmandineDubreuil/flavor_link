<?php

namespace App\Form;

use App\Entity\Amis;
use App\Entity\Repas;
use App\Entity\Recettes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateRepas')
            ->add('recette', EntityType::class, [
                'class' => Recettes::class,
                'choice_label' => 'titre',
                'multiple' => false,
             ])
            ->add('amis', EntityType::class, [
                'class' => Amis::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
             ])
            ->add('resultat')
            ->add('commentaire')

            //  ->add('user')
        ;
        //  dd($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repas::class,
        ]);
    }
}
