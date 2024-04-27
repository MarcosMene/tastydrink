<?php

namespace App\Twig;

use App\Classe\Cart;
use App\Repository\CategoryRepository;
use App\Repository\DrinkCategoryRepository;
use App\Repository\FoodCategoryRepository;
use App\Repository\TeamRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

//function to display the price format
class AppExtensions extends AbstractExtension implements GlobalsInterface
{
  private $categoryRepository;
  private $drinkCategoryRepository;
  private $cart;

  public function __construct(CategoryRepository $categoryRepository, Cart $cart, DrinkCategoryRepository $drinkCategoryRepository, FoodCategoryRepository $foodCategoryRepository, TeamRepository $teamRepository)
  {
    $this->cart = $cart;
    $this->categoryRepository = $categoryRepository;
    $this->drinkCategoryRepository = $drinkCategoryRepository;
    $this->foodCategoryRepository = $foodCategoryRepository;
    $this->teamRepository = $teamRepository;
  }


  public function getFilters()
  {
    return [
      new TwigFilter('price', [$this, 'formatPrice']),
    ];
  }

  public function formatPrice($number)
  {
    return '$ ' . number_format($number, '2', '.', ',');
  }




  //variable global get all categories on all pages

  public function getGlobals(): array
  {
    return [
      'allDrinkCategories' => $this->drinkCategoryRepository->findAll(),
      'allFoodCategories' => $this->foodCategoryRepository->findAll(),
      'allCategories' => $this->categoryRepository->findAll(),
      'fullCartQuantity' => $this->cart->fullQuantity(),
      'teamCategories' => $this->teamRepository->findAll(),
    ];
  }
}
