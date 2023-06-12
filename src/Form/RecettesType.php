<?php

namespace App\Form;

use App\Entity\Recettes;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,['required' => true, 
            ])
            ->add('ingredientsAll', CKEditorType::class, ['label' => 'Liste des Ingrédients :'])
            ->add('tpsPreparation', NumberType::class, [               'required' => true, 
            ])
            ->add('tpsCuisson')
            ->add('tpsRepos')
            ->add('preparation', CKEditorType::class, ['label' => 'Préparation :'])
            ->add('photo', FileType::class, [
                'label' => 'photo (fichier image) ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Merci de télécharger une image valide.',
                    ])
                ]
            ])
            ->add('saison')
            ->add('nbPersonnes')
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
