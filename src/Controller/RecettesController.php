<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Form\RecettesType;
use App\Repository\RecettesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recettes')]
class RecettesController extends AbstractController
{
    #[Route('/', name: 'app_recettes_index', methods: ['GET'])]
    public function index(RecettesRepository $recettesRepository): Response
    {
        return $this->render('recettes/index.html.twig', [
            'recettes' => $recettesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recettes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RecettesRepository $recettesRepository): Response
    {
        $recette = new Recettes();
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recettesRepository->save($recette, true);

            return $this->redirectToRoute('app_recettes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recettes/new.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recettes_show', methods: ['GET'])]
    public function show(Recettes $recette): Response
    {
        $amis = $recette->getAmis();
        return $this->render('recettes/show.html.twig', [
            'recette' => $recette,
            'amis' => $amis,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recettes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recettes $recette, RecettesRepository $recettesRepository): Response
    {
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recettesRepository->save($recette, true);

            return $this->redirectToRoute('app_recettes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recettes/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recettes_delete', methods: ['POST'])]
    public function delete(Request $request, Recettes $recette, RecettesRepository $recettesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $recettesRepository->remove($recette, true);
        }

        return $this->redirectToRoute('app_recettes_index', [], Response::HTTP_SEE_OTHER);
    }
}
