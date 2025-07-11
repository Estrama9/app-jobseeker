<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\City;
use App\Enum\Entitlement;
use App\Enum\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const ADMIN = 'admin';
    const USER1 = 'user1';
    const USER2 = 'user2';
    const USER3 = 'user3';
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('cfrodrigues9@gmail.com');
        $user->setPlainPassword('demo');
        $user->setRoles([UserRole::ADMIN->value]);
        $user->setFullName('Carlos Rodrigues');
        $user->setCity(City::PARIS);
        // $user->setEntitlement(Entitlement::ADMIN);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('toto@gmail.com');
        $user->setPlainPassword('demo');
        $user->setRoles([UserRole::USER->value, UserRole::CANDIDATE->value]);
        $user->setFullName('Toto Doe');
        $user->setCity(City::BORDEAUX);
        // $user->setEntitlement(Entitlement::CANDIDATE);
        $this->addReference(self::USER1, $user);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('tata@gmail.com');
        $user->setPlainPassword('demo');
        $user->setRoles([UserRole::USER->value, UserRole::EMPLOYER->value]);
        $user->setFullName('Tata Doe');
        $user->setCity(City::TOULOUSE);
        // $user->setEntitlement(Entitlement::EMPLOYER);
        $this->addReference(self::USER2, $user);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('titi@gmail.com');
        $user->setPlainPassword('demo');
        $user->setRoles([UserRole::USER->value, UserRole::EMPLOYER->value]);
        $user->setFullName('Titi Doe');
        $user->setCity(City::LILLE);
        // $user->setEntitlement(Entitlement::EMPLOYER);
        $this->addReference(self::USER3, $user);
        $manager->persist($user);

        $manager->flush();
    }
}
