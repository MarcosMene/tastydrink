<?php

namespace App\Controller\Admin;

use App\Entity\BarTime;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\ColorProduct;
use App\Entity\CountryProduct;
use App\Entity\Departament;
use App\Entity\Drink;
use App\Entity\DrinkCategory;
use App\Entity\Employee;
use App\Entity\Food;
use App\Entity\FoodCategory;
use App\Entity\Header;
use App\Entity\Newsletter;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Reservation;
use App\Entity\Review;
use App\Entity\ReviewClient;
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
        yield MenuItem::section('Product');
        yield MenuItem::linkToCrud('Products', 'fas fa-box-open', Product::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Color', 'fas fa-palette', ColorProduct::class);
        yield MenuItem::linkToCrud('Country', 'fas fa-globe', CountryProduct::class);
        yield MenuItem::linkToCrud('Carriers', 'fas fa-truck-fast', Carrier::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-cart-shopping', Order::class);
        yield MenuItem::section('Header');
        yield MenuItem::linkToCrud('Header', 'fas fa-images', Header::class);
        yield MenuItem::section('Team');
        yield MenuItem::linkToCrud('Employee', 'fas fa-clipboard-user', Employee::class);
        yield MenuItem::linkToCrud('Team', 'fas fa-users', Team::class);
        yield MenuItem::linkToCrud('Department', 'fas fa-share-nodes', Departament::class);
        yield MenuItem::section('Menu');
        yield MenuItem::linkToCrud('Drink', 'fas fa-wine-glass-empty', Drink::class);
        yield MenuItem::linkToCrud('Category drink', 'fas fa-wine-bottle', DrinkCategory::class);
        yield MenuItem::linkToCrud('Food', 'fas fa-burger', Food::class);
        yield MenuItem::linkToCrud('Category food', 'fas fa-utensils', FoodCategory::class);
        yield MenuItem::section('Open close hours');
        yield MenuItem::linkToCrud('Shop open/close', 'fas fa-clock', ShopTime::class);
        yield MenuItem::linkToCrud('Bar open/close', 'fas fa-clock', BarTime::class);
        yield MenuItem::section('Reservations');
        yield MenuItem::linkToCrud('Reservation', 'fas fa-rectangle-list', Reservation::class);
        yield MenuItem::section('Reviews');
        yield MenuItem::linkToCrud('Product review', 'fas fa-heart', Review::class);
        yield MenuItem::linkToCrud('Client bar review ', 'fas fa-face-smile', ReviewClient::class);
        yield MenuItem::section('Newsletter');
        yield MenuItem::linkToCrud('Newsletter', 'fas fa-envelope-open-text', Newsletter::class);
    }
}
