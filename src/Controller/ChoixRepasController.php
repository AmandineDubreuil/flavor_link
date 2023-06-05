<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChoixRepasController extends AbstractController
{
    #[Route('/choix/repas', name: 'app_choix_repas')]
    public function index(): Response
    {
        return $this->render('choix_repas/index.html.twig', [
            'controller_name' => 'ChoixRepasController',
        ]);
    }
}
