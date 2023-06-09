<?php

namespace App\Controller;


use App\Entity\Allergies;
use App\Form\AllergiesType;
use App\Repository\AllergiesRepository;
use App\Repository\AmisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/allergies')]
class AllergiesController extends AbstractController
{
    #[Route('/', name: 'app_allergies_index', methods: ['GET'])]
    public function index(AllergiesRepository $allergiesRepository): Response
    {
        return $this->render('allergies/index.html.twig', [
            'allergies' => $allergiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_allergies_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AllergiesRepository $allergiesRepository, AmisRepository $amisRepository): Response
    {
        $idAmi = $_GET['idAmi'];


        $allergy = new Allergies();
        $ami = $amisRepository->findOneById($idAmi);
        // dd($ami);
        $form = $this->createForm(AllergiesType::class, $allergy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $allergy->setAmi($ami);
            $allergiesRepository->save($allergy, true);

            return $this->redirectToRoute('app_amis_show', [
                'id' => $idAmi,
              
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('allergies/new.html.twig', [
            'allergy' => $allergy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_allergies_show', methods: ['GET'])]
    public function show(Allergies $allergy): Response
    {
        return $this->render('allergies/show.html.twig', [
            'allergy' => $allergy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_allergies_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Allergies $allergy, AllergiesRepository $allergiesRepository): Response
    {
        $idAmi = $_GET['idAmi'];

        $form = $this->createForm(AllergiesType::class, $allergy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $allergiesRepository->save($allergy, true);

            return $this->redirectToRoute('app_amis_show', [
                'id' => $idAmi,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('allergies/edit.html.twig', [
            'allergy' => $allergy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_allergies_delete', methods: ['POST'])]
    public function delete(Request $request, Allergies $allergy, AllergiesRepository $allergiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $allergy->getId(), $request->request->get('_token'))) {
            $allergiesRepository->remove($allergy, true);
        }

        return $this->redirectToRoute('app_amis_index', [], Response::HTTP_SEE_OTHER);
    }
}
