<?php

namespace App\Controller;

use App\Entity\Detestes;
use App\Form\DetestesType;
use App\Repository\DetestesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/detestes')]
class DetestesController extends AbstractController
{
    #[Route('/', name: 'app_detestes_index', methods: ['GET'])]
    public function index(DetestesRepository $detestesRepository): Response
    {
        return $this->render('detestes/index.html.twig', [
            'detestes' => $detestesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_detestes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DetestesRepository $detestesRepository): Response
    {
        $detestis = new Detestes();
        $form = $this->createForm(DetestesType::class, $detestis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detestesRepository->save($detestis, true);

            return $this->redirectToRoute('app_detestes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detestes/new.html.twig', [
            'detestis' => $detestis,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detestes_show', methods: ['GET'])]
    public function show(Detestes $detestis): Response
    {
        return $this->render('detestes/show.html.twig', [
            'detestis' => $detestis,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detestes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Detestes $detestis, DetestesRepository $detestesRepository): Response
    {
        $form = $this->createForm(DetestesType::class, $detestis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detestesRepository->save($detestis, true);

            return $this->redirectToRoute('app_detestes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detestes/edit.html.twig', [
            'detestis' => $detestis,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detestes_delete', methods: ['POST'])]
    public function delete(Request $request, Detestes $detestis, DetestesRepository $detestesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detestis->getId(), $request->request->get('_token'))) {
            $detestesRepository->remove($detestis, true);
        }

        return $this->redirectToRoute('app_detestes_index', [], Response::HTTP_SEE_OTHER);
    }
}
