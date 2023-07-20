<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Form\IngredientsType;
use App\Repository\IngredientsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ingredients')]
class IngredientsController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/', name: 'app_ingredients_index', methods: ['GET'])]
    public function index(IngredientsRepository $ingredientsRepository): Response
    {
        return $this->render('ingredients/index.html.twig', [
            'ingredients' => $ingredientsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ingredients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IngredientsRepository $ingredientsRepository): Response
    {
        $userId = $this->security->getUser();
        $recette = $_GET['recette'];

        $ingredient = new Ingredients();
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient->setUser($userId);
            $ingredientsRepository->save($ingredient, true);

            return $this->redirectToRoute('app_recette_ingredients_new', [
                'recette' => $recette,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ingredients/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
            'recette' => $recette
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_show', methods: ['GET'])]
    public function show(Ingredients $ingredient): Response
    {
        return $this->render('ingredients/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ingredients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ingredients $ingredient, IngredientsRepository $ingredientsRepository): Response
    {
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientsRepository->save($ingredient, true);

            return $this->redirectToRoute('app_ingredients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ingredients/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingredients_delete', methods: ['POST'])]
    public function delete(Request $request, Ingredients $ingredient, IngredientsRepository $ingredientsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ingredient->getId(), $request->request->get('_token'))) {
            $ingredientsRepository->remove($ingredient, true);
        }

        return $this->redirectToRoute('app_ingredients_index', [], Response::HTTP_SEE_OTHER);
    }
}
