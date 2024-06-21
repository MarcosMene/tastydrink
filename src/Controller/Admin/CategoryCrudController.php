<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Category')
            ->setEntityLabelInPlural('Categories');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel('Title')->setHelp('Title of the category')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 3,
                            'max' => 20,
                            'minMessage' => 'Title must be at least {{ limit }} characters long',
                            'maxMessage' => 'Title cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-\0-9]/',
                            'message' => 'Title can only contain letters, numbers, and underscores',
                        ]),
                    ]
                ]),
            SlugField::new('slug')->setLabel('URL')->setTargetFieldName('name')->setHelp('URL of the category based on the title'),
            ImageField::new('illustration')
                ->setBasePath('/uploads/category') // the base path where files are stored
                ->setUploadDir('public/uploads/category') // the relative directory to store files in
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
                ->setRequired(false)
                ->setHelp('Image of your category, max 500x500px')
        ];
    }
}
