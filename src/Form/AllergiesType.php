<?php

namespace App\Form;

use App\Entity\Allergies;
use App\Entity\CategoriesIngr;
use App\Entity\Ingredients;
use App\Entity\SuperCategorieIngr;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AllergiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('superCategorieIngr', EntityType::class, [
                'class' => SuperCategorieIngr::class,
                'label' => 'Famille de produits ',
                'choice_label' => 'superCategorie',
                'placeholder' => 'Choisissez un élément',
                'required' => false,
             //   'allow_clear' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.superCategorie', 'ASC');
                },
                'attr' => [
                    'class' => 'selectIngredient'
                ]

            ])
            ->add('categorieIngredients', EntityType::class, [
                'class' => CategoriesIngr::class,
                'label' => 'Sous-famille de produits ',
                'choice_label' => 'categorie',
                'placeholder' => 'Choisissez un élément',
                'required' => false,
             //   'allow_clear' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.categorie', 'ASC');
                },
                'attr' => [
                    'class' => 'selectIngredient'
                ]

            ])

            ->add('ingredient', EntityType::class, [
                'class' => Ingredients::class,
                'label' => 'Ingrédient ',
                'choice_label' => 'ingredient',
                'placeholder' => 'Choisissez un élément',
                'required' => false,
               // 'allow_clear' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.ingredient', 'ASC');
                },
                'attr' => [
                    'class' => 'selectIngredient'
                ]

            ])
            // ->add('ami')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Allergies::class,
        ]);
    }
}
