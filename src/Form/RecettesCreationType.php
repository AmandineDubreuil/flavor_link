<?php

namespace App\Form;

use App\Entity\Recettes;
use App\Entity\CategoriesRecette;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecettesCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
            ])
            ->add('categoriesRecette', EntityType::class, [
                'class' => CategoriesRecette::class,
                'label' => 'Catégorie de recettes ',
                'choice_label' => 'categorie',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'data' => $options['data']->getCategoriesRecette(), // Pass the values from the database

            ])
            ->add('saison', ChoiceType::class, [
                'label' => 'Saison(s) :',
                'choices' => [
                    'Printemps' => 'Printemps',
                    'Été' => 'Été',
                    'Automne' => 'Automne',
                    'Hiver' => 'Hiver',
                ],
                'expanded' => true,
                'multiple' => true,
                'data' => $options['data']->getSaison(), // Pass the values from the database
            ])
            ->add('nbPersonnes', NumberType::class, [
                'required' => true,
            ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
        ]);
    }
}
