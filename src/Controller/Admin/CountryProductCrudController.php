<?php

namespace App\Controller\Admin;

use App\Entity\CountryProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CountryProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CountryProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Country of product')
            ->setEntityLabelInPlural('Countries of product');
    }
}
