<?php

namespace App\Controller;

use App\Entity\Detestes;
use App\Form\DetestesType;
use App\Repository\DetestesRepository;
use App\Repository\AmisRepository;
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
    public function new(Request $request, DetestesRepository $detestesRepository, AmisRepository $amisRepository): Response
    {
        $idAmi = $_GET['idAmi'];

        $deteste = new Detestes();
        $ami = $amisRepository->findOneById($idAmi);
        $form = $this->createForm(DetestesType::class, $deteste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deteste->setAmi($ami);
            $detestesRepository->save($deteste, true);

            return $this->redirectToRoute('app_amis_show', [
                'id' => $idAmi,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detestes/new.html.twig', [
            'detestes' => $deteste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detestes_show', methods: ['GET'])]
    public function show(Detestes $deteste): Response
    {
        return $this->render('detestes/show.html.twig', [
            'deteste' => $deteste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detestes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Detestes $deteste, DetestesRepository $detestesRepository): Response
    {
        $idAmi = $_GET['idAmi'];

        $form = $this->createForm(DetestesType::class, $deteste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detestesRepository->save($deteste, true);

            return $this->redirectToRoute('app_amis_show', [
                'id' => $idAmi,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detestes/edit.html.twig', [
            'deteste' => $deteste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detestes_delete', methods: ['POST'])]
    public function delete(Request $request, Detestes $deteste, DetestesRepository $detestesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deteste->getId(), $request->request->get('_token'))) {
            $detestesRepository->remove($deteste, true);
        }

        return $this->redirectToRoute('app_amis_index', [], Response::HTTP_SEE_OTHER);
    }
}
