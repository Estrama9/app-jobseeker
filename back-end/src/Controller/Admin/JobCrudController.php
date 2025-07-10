<?php

namespace App\Controller\Admin;

use App\Entity\Job;
use App\Enum\City;
use App\Enum\EducationLevel;
use App\Enum\ExperienceLevel;
use App\Enum\JobType;
use App\Enum\StatusJob;
use App\Enum\WorkMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Job::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('company');
        yield TextField::new('title');
        yield TextEditorField::new('description');
        yield ChoiceField::new('city')->setChoices(City::cases());
        yield ChoiceField::new('jobType')->setChoices(JobType::cases());
        yield ChoiceField::new('workMode')->setChoices(WorkMode::cases());
        yield ChoiceField::new('statusJob')->setChoices(StatusJob::cases());
        yield NumberField::new('minSalary');
        yield NumberField::new('maxSalary');
        yield ChoiceField::new('educationLevel')->setChoices(EducationLevel::cases());
        yield ChoiceField::new('experienceLevel')->setChoices(ExperienceLevel::cases());
        yield NumberField::new('hiringLimit');
        yield DateField::new('createdAt');
        yield DateField::new('expirationDate');
    }
}
