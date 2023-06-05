<?php

namespace App\Controller;

use App\Entity\Repas;
use App\Entity\Amis;
use App\Entity\Recettes;
use App\Form\ChoixrepasType;
use App\Repository\RepasRepository;
use App\Repository\AmisRepository;
use App\Repository\RecettesRepository;
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
    public function index(Request $request, RepasRepository $repasRepository, AmisRepository $amisRepository, RecettesRepository $recettesRepository): Response
    {
        $user = $this->security->getUser();

        $amis = $amisRepository->findBy(['user' => $user]);
        $recettes = $recettesRepository->findBy(['user' => $user]);

        if ($request->isMethod('POST') && $request->request->has('submit')) {
            // définir les amis présents
            $amisPresentsId = $request->request->all('amisPourRecettes');
            $amisPresents = $amisRepository->findBy(['id' => $amisPresentsId]);
            // filtrer les recettes selon les amis présents
            $recettesSansAllergie = $recettesRepository->findByAllergie('cabillaud');
        }

        return $this->render('choixrepas/index.html.twig', [
            'controller_name' => 'ChoixrepasController',
            'amis' => $amis,
            'recettesSansAllergie' => $recettesSansAllergie,
            'amisPresents' => $amisPresents,
        ]);
    }
}
