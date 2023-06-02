<?php

namespace App\Controller;

use App\Entity\Deplaire;
use App\Form\DeplaireType;
use App\Repository\DeplaireRepository;
use App\Repository\AmisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/deplaire')]
class DeplaireController extends AbstractController
{
    #[Route('/', name: 'app_deplaire_index', methods: ['GET'])]
    public function index(DeplaireRepository $deplaireRepository): Response
    {
        return $this->render('deplaire/index.html.twig', [
            'deplaires' => $deplaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_deplaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DeplaireRepository $deplaireRepository, AmisRepository $amisRepository): Response
    {
        $idAmi = $_GET['idAmi'];

        $deplaire = new Deplaire();
        $ami = $amisRepository->findOneById($idAmi);
        $form = $this->createForm(DeplaireType::class, $deplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deplaire->setAmi($ami);
            $deplaireRepository->save($deplaire, true);

            return $this->redirectToRoute('app_amis_show', [
                'id' => $idAmi,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deplaire/new.html.twig', [
            'deplaire' => $deplaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deplaire_show', methods: ['GET'])]
    public function show(Deplaire $deplaire): Response
    {
        return $this->render('deplaire/show.html.twig', [
            'deplaire' => $deplaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_deplaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Deplaire $deplaire, DeplaireRepository $deplaireRepository): Response
    {
        $idAmi = $_GET['idAmi'];

        $form = $this->createForm(DeplaireType::class, $deplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deplaireRepository->save($deplaire, true);

            return $this->redirectToRoute('app_amis_show', [
                'id' => $idAmi,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deplaire/edit.html.twig', [
            'deplaire' => $deplaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deplaire_delete', methods: ['POST'])]
    public function delete(Request $request, Deplaire $deplaire, DeplaireRepository $deplaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $deplaire->getId(), $request->request->get('_token'))) {
            $deplaireRepository->remove($deplaire, true);
        }

        return $this->redirectToRoute('app_amis_index', [], Response::HTTP_SEE_OTHER);
    }
}
