<?php

namespace App\DataFixtures;

use App\Entity\Application;
use App\Entity\Candidate;
use App\Entity\Job;
use App\Enum\StatusApplication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $application = new Application();
        $application->setStatusApplication(StatusApplication::ACTIVE);
        $application->setCv('');
        $application->setCoverLetter('');
        $application->setTitle('Full-Stack Développeur');
        $application->setCandidate($this->getReference(CandidateFixtures::CANDIDATE1, Candidate::class));
        $application->setJob($this->getReference(JobFixtures::JOB1, Job::class));
        $manager->persist($application);

        $application = new Application();
        $application->setStatusApplication(StatusApplication::ACTIVE);
        $application->setCv('');
        $application->setCoverLetter('');
        $application->setTitle('Serveur en Salle');
        $application->setCandidate($this->getReference(CandidateFixtures::CANDIDATE2, Candidate::class));
        $application->setJob($this->getReference(JobFixtures::JOB2, Job::class));
        $manager->persist($application);

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            JobFixtures::class,
            CandidateFixtures::class
        ];
    }
}
