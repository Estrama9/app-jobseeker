<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Enum\StatusApplication;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('candidate');
        yield AssociationField::new('job');
        yield TextField::new('title');
        yield ChoiceField::new('statusApplication')->setChoices(StatusApplication::cases());
        yield TextField::new('cv');
        yield TextField::new('coverLetter');
        yield DateField::new('createdAt');
        yield DateField::new('updatedAt');
    }
}
