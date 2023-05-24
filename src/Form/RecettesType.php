<?php

namespace App\Form;

use App\Entity\Recettes;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('ingredientsAll', CKEditorType::class)
            ->add('tpsPreparation')
            ->add('tpsCuisson')
            ->add('tpsRepos')
            ->add('preparation', CKEditorType::class)
            ->add('photo')
            ->add('saison')
            ->add('nbPersonnes')
            ->add('user')
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
        ]);
    }
}
