<?php

namespace App\Controller;

use App\Entity\RecetteIngredients;
use App\Form\RecetteIngredientsType;
use App\Repository\RecetteIngredientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recette_ingredients')]
class RecetteIngredientsController extends AbstractController
{
    #[Route('/', name: 'app_recette_ingredients_index', methods: ['GET'])]
    public function index(RecetteIngredientsRepository $recetteIngredientsRepository): Response
    {
        return $this->render('recette_ingredients/index.html.twig', [
            'recette_ingredients' => $recetteIngredientsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recette_ingredients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RecetteIngredientsRepository $recetteIngredientsRepository): Response
    {
        $recetteIngredient = new RecetteIngredients();
        $form = $this->createForm(RecetteIngredientsType::class, $recetteIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recetteIngredientsRepository->save($recetteIngredient, true);

            return $this->redirectToRoute('app_recette_ingredients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette_ingredients/new.html.twig', [
            'recette_ingredient' => $recetteIngredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recette_ingredients_show', methods: ['GET'])]
    public function show(RecetteIngredients $recetteIngredient): Response
    {
        return $this->render('recette_ingredients/show.html.twig', [
            'recette_ingredient' => $recetteIngredient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recette_ingredients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecetteIngredients $recetteIngredient, RecetteIngredientsRepository $recetteIngredientsRepository): Response
    {
        $form = $this->createForm(RecetteIngredientsType::class, $recetteIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recetteIngredientsRepository->save($recetteIngredient, true);

            return $this->redirectToRoute('app_recette_ingredients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette_ingredients/edit.html.twig', [
            'recette_ingredient' => $recetteIngredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recette_ingredients_delete', methods: ['POST'])]
    public function delete(Request $request, RecetteIngredients $recetteIngredient, RecetteIngredientsRepository $recetteIngredientsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recetteIngredient->getId(), $request->request->get('_token'))) {
            $recetteIngredientsRepository->remove($recetteIngredient, true);
        }

        return $this->redirectToRoute('app_recette_ingredients_index', [], Response::HTTP_SEE_OTHER);
    }
}
