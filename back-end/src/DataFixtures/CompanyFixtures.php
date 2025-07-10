<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use App\Enum\City;
use App\Enum\Industry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    const COMPANY1='company_1';
    const COMPANY2='company_2';
    public function load(ObjectManager $manager): void
    {
        $company = new Company();
        $company->setName('Donkey Code');
        $company->setDescription('La Team DonkeyCode aujourd\'hui, c\'est une équipe de 15 personnes, 5 femmes et 10 hommes, soudés et motivés ! Nous sommes fiers d\'avoir traversé la crise Covid avec nos clients, et de pouvoir continuer à grandir ensemble, doucement mais sûrement.');
        $company->setCountry('France');
        $company->setCity(City::PARIS);
        $company->setTeamSize(15);
        $company->setEstablishmentDate(\DateTimeImmutable::createFromFormat('d/m/Y', '01/01/2014'));
        $company->setIndustry(Industry::TECHNOLOGY);
        $company->setWebsite('https://www.donkeycode.com/');
        $company->setLogoUrl('');
        $company->setLinkedin('');
        $company->setGithub('');
        $company->setFacebook('');
        $company->setX('');
        $company->setInstagram('');
        $company->setYoutube('');
        $company->setUser($this->getReference(UserFixtures::USER2, User::class));
        $this->setReference(self::COMPANY1, $company);
        $manager->persist($company);

        $company = new Company();
        $company->setName('DonaBela');
        $company->setDescription('Découvrez chez DonaBela des empanadas et rissoles en famille dans le confort de votre maison avec notre service emporter.');
        $company->setCountry('France');
        $company->setCity(City::LILLE);
        $company->setTeamSize(4);
        $company->setEstablishmentDate(\DateTimeImmutable::createFromFormat('d/m/Y', '01/01/2020'));
        $company->setIndustry(Industry::OTHER);
        $company->setWebsite('https://www.donabela.fr/');
        $company->setLogoUrl('');
        $company->setLinkedin('');
        $company->setGithub('');
        $company->setFacebook('');
        $company->setX('');
        $company->setInstagram('');
        $company->setYoutube('');
        $company->setUser($this->getReference(UserFixtures::USER3, User::class));
        $this->setReference(self::COMPANY2, $company);
        $manager->persist($company);

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            UserFixtures::class
        ];
    }
}
