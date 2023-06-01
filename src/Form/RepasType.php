<?php

namespace App\Form;

use App\Entity\Amis;
use App\Entity\Repas;
use App\Entity\Recettes;
use App\Repository\AmisRepository;
use App\Repository\RecettesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepasType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('dateRepas')
            ->add('recette', EntityType::class, [
                'class' => Recettes::class,
                'choice_label' => 'titre',
                'multiple' => false,
                'query_builder' => function (RecettesRepository $er) use ($user) {
                    return $er->createQueryBuilder('a')
                        ->andWhere('a.user = :user')
                        ->setParameter('user', $user);
                },
             ])
            ->add('amis', EntityType::class, [
                'class' => Amis::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (AmisRepository $er) use ($user) {
                    return $er->createQueryBuilder('a')
                        ->andWhere('a.user = :user')
                        ->setParameter('user', $user);
                },
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
