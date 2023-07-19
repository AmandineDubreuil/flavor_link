<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Form\RecettesFinCreationType;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RecetteFinCreationController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }
    #[Route('/recette/fincreation', name: 'app_recette_fin_creation', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecettesRepository $recettesRepository, SluggerInterface $slugger): Response
    {
       
        $recetteId = $_GET['recette'];
       // dd($recetteId);
         $recette = $recettesRepository->find($recetteId);
        $form = $this->createForm(RecettesFinCreationType::class, $recette);
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

        return $this->renderForm('recette_fin_creation/index.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }
}
