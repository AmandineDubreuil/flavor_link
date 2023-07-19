<?php

namespace App\Controller\Admin;

use App\Entity\CategoriesIngr;
use App\Entity\Ingredients;
use App\Entity\SuperCategorieIngr;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Amiam - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Site Amiam', 'fas fa-home', 'app_home');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-people-group', User::class);
        yield MenuItem::linkToCrud('Super Catégories Ingrédients', 'fa-solid fa-people-group', SuperCategorieIngr::class);
        yield MenuItem::linkToCrud('Catégories Ingrédients', 'fa-solid fa-people-group', CategoriesIngr::class);

        yield MenuItem::linkToCrud('Ingrédients', 'fa-solid fa-people-group', Ingredients::class);

        //  yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
