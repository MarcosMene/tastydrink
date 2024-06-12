<?php

namespace App\Controller\Admin;

use App\Entity\ColorProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ColorProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ColorProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Color')
            ->setEntityLabelInPlural('Colors');
    }
}
