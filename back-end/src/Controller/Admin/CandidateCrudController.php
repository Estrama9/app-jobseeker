<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use App\Enum\EducationLevel;
use App\Enum\ExperienceLevel;
use App\Enum\Gender;
use App\Enum\StatusCandidate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user')->onlyOnIndex();
        yield TextField::new('title');
        yield TextEditorField::new('biography');
        yield ChoiceField::new('gender')->setChoices(Gender::cases());
        yield DateField::new('birthday');
        yield ChoiceField::new('educationLevel')->setChoices(EducationLevel::cases());
        yield ChoiceField::new('experienceLevel')->setChoices(ExperienceLevel::cases());
        yield ChoiceField::new('statusCandidate')->setChoices(StatusCandidate::cases());
    }
}
