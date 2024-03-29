<?php

namespace App\Form;

use App\Entity\Ingredients;
use App\Entity\CategoriesIngr;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IngredientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', EntityType::class, [
                'required' => true,
                'class'=> CategoriesIngr::class,
                'label' => 'Catégorie ',
                'choice_label'=> 'categorie',
                'query_builder'=> function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                    ->orderBy('c.categorie', 'ASC');
                },
                'attr'=> [
                    'class' => 'selectCategorieIngr'
                ]
            ])

            ->add('ingredient', TextType::class, [
                'required' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredients::class,
        ]);
    }
}
