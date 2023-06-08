<?php

namespace App\Controller;


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
        $recettesSansAllergie = [];
        $recettesOk = [];
        if ($request->isMethod('POST') && $request->request->has('submit')) {
            // définir les amis présents
            $amisPresentsId = $request->request->all('amisPourRecettes');
            $amisPresents = $amisRepository->findBy(['id' => $amisPresentsId]);

            // définir les allergies des amis présents
            $allergiesPresentes = $allergiesRepository->findBy(['ami' => $amisPresentsId]);

            $allergieArray = [];
            $recettesAvecAllergie = [];

            $recettesOui = [];
            $recettesNon = [];
            $recettesOkId = [];


            foreach ($allergiesPresentes as $allergie) {
                $allergieArray[] = $allergie->getIngredient();
            }
            $allergieArrayUnique = array_unique($allergieArray);

            // récupérer les recettes où des allergies sont présentes
            // récupération sous forme d'array
            foreach ($allergieArrayUnique as $allergie) {
                $recettesAvecAllergie[] = $recettesRepository->findByUserAndAllergie($allergie, $user);
            }

            // pour chaque recette récupérer l'id et mettre dans un tableau si allergie possible
            foreach ($recettes as $recette) {
                $recetteId = $recette->getId();
                $recettesOui[] = $recetteId;
                foreach ($recettesAvecAllergie as $recetteAl => $value) {

                    foreach ($value as $valueUnique) {
                        if ($valueUnique == $recetteId) {
                            $recettesNon[] = $recetteId;
                        }
                    }
                }
            }
            // supprimer les doublons
            $recettesOuiUnique = array_unique($recettesOui);
            $recettesNonUnique = array_unique($recettesNon);

            // supprimer les recettes non du tableau recettes oui
            $recettesOkId = array_diff($recettesOuiUnique, $recettesNonUnique);

            // récupère les objets recettes
            foreach ($recettesOkId as $recetteId) {
                $recettesOk[] = $recettesRepository->find($recetteId);
            }
            //  dd($recettesOk);
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
