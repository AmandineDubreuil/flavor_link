<?php

namespace App\Controller;

use App\Entity\Repas;
use App\Form\RepasType;
use App\Repository\AmisRepository;
use App\Repository\RecettesRepository;
use App\Repository\RepasRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/repas')]
class RepasController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    #[Route('/', name: 'app_repas_index', methods: ['GET'])]
    public function index(RepasRepository $repasRepository): Response
    {
        $user = $this->security->getUser();
        // dd($recettes);
        return $this->render('repas/index.html.twig', [
            'repas' => $repasRepository->findByUser($user),
        ]);
    }

    #[Route('/new', name: 'app_repas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RepasRepository $repasRepository, RecettesRepository $recettesRepository, AmisRepository $amisRepository): Response
    {

        $user = $this->security->getUser();

        $recetteId = $_GET['recetteId'];
        $recette = $recettesRepository->find($recetteId);
        //dd($recette);

        $amisIds = $_GET['amisId'];
      
        
        $repa = new Repas();
        $form = $this->createForm(RepasType::class, $repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repa->setUser($user);
            $repa->setRecette($recette);
            foreach ($amisIds as $amiId) {
                $ami = $amisRepository->find($amiId);
               // dd($ami);
                $repa->addAmi($ami);
            }


            //   dd($repa);
            $repasRepository->save($repa, true);

            return $this->redirectToRoute('app_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repas/new.html.twig', [
            'repa' => $repa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repas_show', methods: ['GET'])]
    public function show(Repas $repa): Response
    {
        return $this->render('repas/show.html.twig', [
            'repa' => $repa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_repas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Repas $repa, RepasRepository $repasRepository): Response
    {
        $form = $this->createForm(RepasType::class, $repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repasRepository->save($repa, true);

            return $this->redirectToRoute('app_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repas/edit.html.twig', [
            'repa' => $repa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repas_delete', methods: ['POST'])]
    public function delete(Request $request, Repas $repa, RepasRepository $repasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $repa->getId(), $request->request->get('_token'))) {
            $repasRepository->remove($repa, true);
        }

        return $this->redirectToRoute('app_repas_index', [], Response::HTTP_SEE_OTHER);
    }
}
