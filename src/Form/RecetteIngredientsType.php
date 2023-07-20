<?php

namespace App\Form;

use App\Entity\Ingredients;
use App\Entity\RecetteIngredients;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RecetteIngredientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', IntegerType::class,[
                'label' => 'Quantité ',
            ])
            ->add('uniteMesure', TextType::class, [
                'label' => 'Unité de mesure (gr, l, cs...) ',
            ])
         //   ->add('recetteId')
            ->add('ingredientId', EntityType::class, [
                'class'=> Ingredients::class,
                'label' => 'Ingrédient ',
                'choice_label'=> 'ingredient',
                'query_builder'=> function(EntityRepository $er){
                    return $er->createQueryBuilder('i')
                    ->orderBy('i.ingredient', 'ASC');
                },
                'attr'=> [
                    'class' => 'selectIngredient'
                ]
        
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecetteIngredients::class,
        ]);
    }
}
