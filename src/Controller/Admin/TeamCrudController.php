<?php

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class TeamCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Team::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Team')
      ->setEntityLabelInPlural('Teams');
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('nameTeam')
        ->setLabel('Name team')
        ->setHelp('Minimum 3, maximum length is 15 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 3,
              'max' => 15,
              'minMessage' => 'Name team must be at least {{ limit }} characters long',
              'maxMessage' => 'Name team cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ\s\-_]*$/',
              'message' => 'Name team can only contain letters and underscores',
            ]),
          ]
        ]),
    ];
  }
}
