<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\Entity\Candidate;
use App\Entity\User;
use App\Enum\EducationLevel;
use App\Enum\ExperienceLevel;
use App\Enum\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CandidateFixtures extends Fixture implements DependentFixtureInterface
{
    const CANDIDATE1 = 'candidate1';
    const CANDIDATE2 = 'candidate2';
    public function load(ObjectManager $manager): void
    {
        $candidate = new Candidate();
        $candidate->setTitle('Front-end Développeur');
        $candidate->setGender(Gender::MALE);
        $candidate->setBirthday(\DateTimeImmutable::createFromFormat('d/m/Y', '18/05/2005'));
        $candidate->setBiography('Toto is a passionate and versatile full-stack web developer with expertise in both frontend and backend technologies. With a solid foundation in JavaScript, React, Node.js, and database management, Toto crafts dynamic, user-friendly web applications that deliver seamless experiences across devices.

Known for a strong problem-solving mindset and attention to detail, Toto combines creative design sensibilities with robust programming skills to build scalable and maintainable codebases. Always eager to learn and adapt, Toto stays updated with the latest industry trends and best practices, ensuring projects are built with modern, efficient technologies.

With experience in agile development environments, Toto collaborates effectively with cross-functional teams to deliver high-quality software on time. Whether developing responsive user interfaces or designing RESTful APIs, Toto is committed to writing clean, efficient code that meets both business goals and user needs.

In addition to technical skills, Toto values clear communication, teamwork, and continuous improvement, making him a reliable and valuable asset to any development team.');
        $candidate->setExperienceLevel(ExperienceLevel::ENTRY);
        $candidate->setEducationLevel(EducationLevel::BACHELOR);
        $candidate->setWebsite('https://toto.dev.com');
        $candidate->setLinkedin('');
        $candidate->setX('');
        $candidate->setGithub('');
        $candidate->setFacebook('');
        $candidate->setInstagram('');
        $candidate->setYoutube('');
        $candidate->setUser($this->getReference(UserFixtures::USER1, User::class));
        $this->setReference(self::CANDIDATE1, $candidate);
        $manager->persist($candidate);

        $candidate = new Candidate();
        $candidate->setTitle('Serveuse');
        $candidate->setGender(Gender::FEMALE);
        $candidate->setBirthday(\DateTimeImmutable::createFromFormat('d/m/Y', '18/05/2005'));
        $candidate->setBiography('Tete est un serveur passionné et polyvalent, doté d’une excellente connaissance du service en salle et d’un grand sens du relationnel. Avec une solide expérience dans la gestion des commandes, le service client et la coordination avec la cuisine, Tete garantit une expérience agréable et fluide pour chaque client.

Reconnu pour son esprit d’équipe, son sens du détail et sa réactivité, Tete combine un accueil chaleureux avec un professionnalisme rigoureux pour assurer un service de qualité. Toujours attentif aux besoins des clients, il sait s’adapter rapidement aux situations et gérer les priorités avec efficacité.

Fort d’une expérience dans des environnements dynamiques et exigeants, Tete travaille en étroite collaboration avec ses collègues pour garantir un service rapide et sans erreur. Que ce soit pour prendre les commandes, conseiller sur la carte ou gérer les paiements, Tete est engagé à offrir un service impeccable qui satisfait à la fois les attentes des clients et les exigences du restaurant.

En plus de ses compétences techniques, Tete accorde une grande importance à la communication claire, au travail en équipe et à l’amélioration continue, faisant de lui un élément fiable et apprécié de toute équipe de restauration.');
        $candidate->setExperienceLevel(ExperienceLevel::ENTRY);
        $candidate->setEducationLevel(EducationLevel::NONE);
        $candidate->setWebsite('https://tete.dev.com');
        $candidate->setLinkedin('');
        $candidate->setX('');
        $candidate->setGithub('');
        $candidate->setFacebook('');
        $candidate->setInstagram('');
        $candidate->setYoutube('');
        $candidate->setUser($this->getReference(UserFixtures::USER4, User::class));
        $this->setReference(self::CANDIDATE2, $candidate);
        $manager->persist($candidate);

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            UserFixtures::class
        ];
    }


}
