<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Enum\City;
use App\Enum\Industry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user');
        yield TextField::new('name');
        yield TextEditorField::new('description');
        yield TextField::new('country');
        yield ChoiceField::new('city')->setChoices(City::cases());
        yield DateField::new('establishmentDate');
        yield NumberField::new('teamSize');
        yield ChoiceField::new('industry')->setChoices(Industry::cases());
    }
}
