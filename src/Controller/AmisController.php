<?php

namespace App\Controller;

use App\Entity\Amis;
use App\Form\AmisType;
use App\Repository\AmisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/amis')]
class AmisController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_amis_index', methods: ['GET'])]
    public function index(AmisRepository $amisRepository): Response
    {
        return $this->render('amis/index.html.twig', [
            'amis' => $amisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_amis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AmisRepository $amisRepository): Response
    {
        $userId = $this->security->getUser();

        $ami = new Amis();
        $form = $this->createForm(AmisType::class, $ami);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ami->setUser($userId);
            $amisRepository->save($ami, true);

            return $this->redirectToRoute('app_amis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('amis/new.html.twig', [
            'ami' => $ami,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_amis_show', methods: ['GET'])]
    public function show(Amis $ami): Response
    {
        return $this->render('amis/show.html.twig', [
            'ami' => $ami,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_amis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Amis $ami, AmisRepository $amisRepository): Response
    {
        $form = $this->createForm(AmisType::class, $ami);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $amisRepository->save($ami, true);

            return $this->redirectToRoute('app_amis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('amis/edit.html.twig', [
            'ami' => $ami,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_amis_delete', methods: ['POST'])]
    public function delete(Request $request, Amis $ami, AmisRepository $amisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ami->getId(), $request->request->get('_token'))) {
            $amisRepository->remove($ami, true);
        }

        return $this->redirectToRoute('app_amis_index', [], Response::HTTP_SEE_OTHER);
    }
}
