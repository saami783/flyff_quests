<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(EventCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Flyff Universe Quests');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkTo(EventCrudController::class, 'Events', 'fa-solid fa-calendar');
        yield MenuItem::linkTo(JobCrudController::class, 'Jobs', 'fa-solid fa-briefcase');
        yield MenuItem::linkTo(TagCrudController::class, 'Tags', 'fa-solid fa-tag');
        yield MenuItem::linkTo(PlayerCrudController::class, 'Players', 'fa-solid fa-gamepad');
        yield MenuItem::linkTo(UserCrudController::class, 'Admins', 'fa-solid fa-users');

        yield MenuItem::linkToRoute('Home',  'fa-solid fa-arrow-right-from-bracket', 'app_home');
    }
}
