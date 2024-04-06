<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $required = true;

        if ($pageName == 'edit') {
            $required = false;
        }

        return [
            TextField::new('title'),
            TextareaField::new('content'),
            TextField::new('buttonTitle'),
            TextField::new('buttonLink', 'URL of button'),
            ImageField::new('illustration')
                ->setBasePath('/uploads/header_carousel') // the base path where files are stored
                ->setUploadDir('public/uploads/header_carousel') // the relative directory to store files in
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
                ->setHelp('Image of carousel')
                ->setRequired($required)

        ];
    }
}
