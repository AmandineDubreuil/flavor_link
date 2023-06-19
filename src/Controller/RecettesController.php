<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Form\RecettesType;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/recettes')]
class RecettesController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_recettes_index', methods: ['GET'])]
    public function index(RecettesRepository $recettesRepository): Response
    {

        return $this->render('recettes/index.html.twig', [
            'recettes' => $recettesRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_recettes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RecettesRepository $recettesRepository,  SluggerInterface $slugger): Response
    {
        $user = $this->security->getUser();

        $recette = new Recettes();
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);


        //validation du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $recette->setUser($user);
            $recettesRepository->save($recette, true);
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();
                //dd($originalFilename);
                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'photoFilename' property to store the image file name
                // instead of its contents
                $recette->setPhoto($newFilename);

                // Get the EntityManager and persist the entity
                $entityManager = $this->entityManager;
                $entityManager->persist($recette);
                $entityManager->flush();
            }
          
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
        $repas = $recette->getRepas();
        return $this->render('recettes/show.html.twig', [
            'recette' => $recette,
            'repas' => $repas,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recettes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recettes $recette, RecettesRepository $recettesRepository,  SluggerInterface $slugger): Response
    {
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recettesRepository->save($recette, true);
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                //supprimer l'ancienne photo
                $oldPhotoFilename = $recette->getPhoto();
                if ($oldPhotoFilename) {
                    $oldPhotoPath = $this->getParameter('photos_directory') . '/' . $oldPhotoFilename;

                    // Vérifier si le fichier existe avant de le supprimer
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                // enregistrer nouvelle photo
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();
                //dd($originalFilename);
                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'photoFilename' property to store the image file name
                // instead of its contents
                $recette->setPhoto($newFilename);

                // Get the EntityManager and persist the entity
                $entityManager = $this->entityManager;
                $entityManager->persist($recette);
                $entityManager->flush();
            }


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
        if ($this->isCsrfTokenValid('delete' . $recette->getId(), $request->request->get('_token'))) {
            $recettesRepository->remove($recette, true);
        }

        return $this->redirectToRoute('app_recettes_index', [], Response::HTTP_SEE_OTHER);
    }
}
