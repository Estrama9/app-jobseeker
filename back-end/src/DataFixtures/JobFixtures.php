<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Job;
use App\Enum\City;
use App\Enum\Country;
use App\Enum\EducationLevel;
use App\Enum\ExperienceLevel;
use App\Enum\JobType;
use App\Enum\StatusJob;
use App\Enum\WorkMode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JobFixtures extends Fixture implements DependentFixtureInterface
{
    const JOB1 = 'job1';
    const JOB2= 'job2';
    public function load(ObjectManager $manager): void
    {
        $job = new Job();
        $job->setTitle('Front-End Développeur');
        $job->setDescription('Ta mission
En tant que Front-End Développeur, tu seras au cœur de l’expérience utilisateur de DonkeySchool. Tu travailleras en étroite collaboration avec notre équipe produit, design et back-end pour créer des interfaces réactives, accessibles et performantes.

Tes responsabilités

Développer des interfaces modernes en HTML, CSS (Tailwind) et JavaScript (React/Next.js).

Intégrer des maquettes issues de Figma avec précision.

Optimiser le rendu et les performances sur desktop et mobile.

Collaborer avec les designers UX/UI pour améliorer l’expérience utilisateur.

Participer aux revues de code, tests et déploiements CI/CD.

Être force de proposition sur les choix techniques front-end.

Profil recherché

Maîtrise des bases : HTML5, CSS3, JavaScript ES6+.

Bonnes connaissances de React.js (ou autre framework JS moderne).

Sensibilité à l’accessibilité, à la performance et à l’expérience utilisateur.

Esprit d’équipe, autonomie et curiosité technique.

Une première expérience (stage, freelance, projet personnel) est un plus.

Tu es passionné(e) par le code, l’éducation ou les deux !

Ce qu’on t’offre

Un environnement bienveillant, formateur et stimulant.

Des projets concrets ayant un vrai impact social.

Une culture produit et tech centrée sur la qualité et l’apprentissage.

Télétravail possible, horaires flexibles.

Matériel et formations à la demande.

');
        $job->setCity(City::PARIS);
        $job->setJobType(JobType::FULL_TIME);
        $job->setWorkMode(WorkMode::HYBRID);
        $job->setStatusJob(StatusJob::OPEN);
        $job->setMinSalary(45000);
        $job->setMaxSalary(60000);
        $job->setEducationLevel(EducationLevel::BACHELOR);
        $job->setExperienceLevel(ExperienceLevel::MID);
        $job->setExpirationDate((new \DateTimeImmutable())->modify('+1 month'));
        $job->setHiringLimit(1);
        $job->setCompany($this->getReference(CompanyFixtures::COMPANY1, Company::class));
        $this->setReference(self::JOB1, $job);
        $manager->persist($job);

        $job = new Job();
        $job->setTitle('Serveur en Salle');
        $job->setDescription('En tant que serveur(se), tu seras au cœur de l’expérience client de notre établissement. Ton sourire, ton efficacité et ton sens du service contribueront directement à la satisfaction de nos clients. Tu travailleras main dans la main avec l’équipe cuisine, la direction et les autres membres de la salle pour offrir un service chaleureux, rapide et professionnel.');
        $job->setCity(City::LILLE);
        $job->setJobType(JobType::PART_TIME);
        $job->setWorkMode(WorkMode::ON_SITE);
        $job->setStatusJob(StatusJob::OPEN);
        $job->setMinSalary(25000);
        $job->setMaxSalary(30000);
        $job->setEducationLevel(EducationLevel::NONE);
        $job->setExperienceLevel(ExperienceLevel::ENTRY);
        $job->setExpirationDate((new \DateTimeImmutable())->modify('+1 month'));
        $job->setHiringLimit(1);
        $job->setCompany($this->getReference(CompanyFixtures::COMPANY2, Company::class));
        $this->setReference(self::JOB2, $job);
        $manager->persist($job);

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            CompanyFixtures::class
        ];
    }
}
