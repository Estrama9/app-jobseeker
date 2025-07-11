<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\City;
use App\Enum\Entitlement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\ExpressionLanguage\Expression;

class UserCrudController extends AbstractCrudController
{
    public function __construct(private Security $security) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');
        yield TextField::new('fullname');
        yield TextField::new('plainPassword')
            ->setRequired(false)
            ->onlyOnForms()
            ->setHelp('Leave blank to keep current password.');
            //->setPermission('["ROLE_ADMIN"]');
        yield ArrayField::new('roles');
        yield TextField::new('country');
        yield ChoiceField::new('city')->setChoices(City::cases());
        // yield ChoiceField::new('entitlement')->setChoices(Entitlement::cases());
        yield DateField::new('createdAt');
        yield DateField::new('updatedAt');
        yield BooleanField::new('isVerified');
    }
}
