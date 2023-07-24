<?php

namespace App\Controller;

use App\Entity\Allergies;
use App\Entity\Recettes;
use App\Repository\AmisRepository;
use App\Repository\RepasRepository;
use App\Repository\RecettesRepository;
use App\Repository\AllergiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChoixrepasController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/choixrepas', name: 'app_choixrepas')]
    public function index(Request $request, RepasRepository $repasRepository, AmisRepository $amisRepository, AllergiesRepository $allergiesRepository, RecettesRepository $recettesRepository): Response
    {
        $user = $this->security->getUser();
        $amis = $amisRepository->findBy(['user' => $user]);
        $recettes = $recettesRepository->findBy(['user' => $user]);

        $amisPresents = "";
        $amisPresentsId = "";
        $recettesAvecAllergie = [];
        $recettesOk = [];
        if ($request->isMethod('POST') && $request->request->has('submit')) {
            // définir les amis présents
            $amisPresentsId = $request->request->all('amisPourRecettes');
            $amisPresents = $amisRepository->findBy(['id' => $amisPresentsId]);
            // définir les allergies des amis présents
            $allergiesPresentes = $allergiesRepository->findBy(['ami' => $amisPresentsId]);

            // récupération d'un tableau des super catégories avec allergies
            $superCategoriesArray = [];
            foreach ($allergiesPresentes as $allergieSuperCategorie) {
                $superCategorie =   $allergieSuperCategorie->getSuperCategorieIngr();
                if ($superCategorie == !null) {
                    $superCategoriesArray[] = $superCategorie;
                }
            }

            // récupération d'un tableau des catégories avec allergies
            $categoriesArray = [];
            foreach ($allergiesPresentes as $allergieCategorie) {
                $categorie =   $allergieCategorie->getCategorieIngredients();
                if ($categorie == !null) {
                    $categoriesArray[] = $categorie;
                }
            }

            // récupération d'un tableau des ingredients avec allergies
            $ingredientsArray = [];
            foreach ($allergiesPresentes as $allergieIngredient) {
                $ingredient =   $allergieIngredient->getIngredient();
                //  dd($ingredient);
                if ($ingredient == !null) {
                    $ingredientsArray[] = $ingredient;
                }
            }
            // récupération des recettes avec allergies dans un tableau
            foreach ($recettes as $recette) {


                foreach ($recette->getIngredients() as $ingredientRecette) {
                    $ingredientId = $ingredientRecette->getIngredientId();
                    $categorieId = $ingredientId->getCategorie();
                    $superCategorieId = $categorieId->getSuperCategorieIngr();
                    // dd($ingredientId->getCategorie()); 
                    //  dd($superCategorieId);

                    // pour ingrédient
                    if (in_array($ingredientId, $ingredientsArray)) {
                        // Ajout de la recette au tableau "recettesAvecAllergie"
                        $recettesAvecAllergie[] = $recette;
                    }

                    // pour catégorie
                    if (in_array($categorieId, $categoriesArray)) {
                        // Ajout de la recette au tableau "recettesAvecAllergie"
                        $recettesAvecAllergie[] = $recette;
                    }

                    // pour super catégorie
                    if (in_array($superCategorieId, $superCategoriesArray)) {
                        // Ajout de la recette au tableau "recettesAvecAllergie"
                        $recettesAvecAllergie[] = $recette;
                    }
                }
            }
            // supprimer les doublons du tableau recettesAvecAllergie
            $recettesAvecAllergieUnique = array_unique($recettesAvecAllergie);

            // retirer les recettes du tableau avec allergie du tableau recettes
            $recettesOk = array_diff($recettes, $recettesAvecAllergieUnique);

            // test
            // dd($recettesOk);
        }
        return $this->render('choixrepas/index.html.twig', [
            'controller_name' => 'ChoixrepasController',
            'amis' => $amis,
            'recettesOk' => $recettesOk,
            'amisPresents' => $amisPresents,
            'amisId' => $amisPresentsId,
        ]);
    }
}
