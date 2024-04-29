<?php

namespace App\Controller\Admin;

use App\Entity\BarTime;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Departament;
use App\Entity\Drink;
use App\Entity\DrinkCategory;
use App\Entity\Employee;
use App\Entity\Food;
use App\Entity\FoodCategory;
use App\Entity\Header;
use App\Entity\MenuDrink;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ShopTime;
use App\Entity\Team;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<a href="/">Tastydrink</a>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('User');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-tag', Product::class);
        yield MenuItem::linkToCrud('Carriers', 'fas fa-tag', Carrier::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-tag', Order::class);
        yield MenuItem::section('Header');
        yield MenuItem::linkToCrud('Header', 'fas fa-tag', Header::class);
        yield MenuItem::section('Team');
        yield MenuItem::linkToCrud('Employee', 'fas fa-tag', Employee::class);
        yield MenuItem::linkToCrud('Team', 'fas fa-tag', Team::class);
        yield MenuItem::linkToCrud('Department', 'fas fa-tag', Departament::class);
        yield MenuItem::section('Menu');
        yield MenuItem::linkToCrud('Drink', 'fas fa-tag', Drink::class);
        yield MenuItem::linkToCrud('Menu drink', 'fas fa-tag', DrinkCategory::class);
        yield MenuItem::linkToCrud('Food', 'fas fa-tag', Food::class);
        yield MenuItem::linkToCrud('Menu food', 'fas fa-tag', FoodCategory::class);
        yield MenuItem::section('Open close hours');
        yield MenuItem::linkToCrud('Shop open/close', 'fas fa-tag', ShopTime::class);
        yield MenuItem::linkToCrud('Bar open/close', 'fas fa-tag', BarTime::class);
    }
}