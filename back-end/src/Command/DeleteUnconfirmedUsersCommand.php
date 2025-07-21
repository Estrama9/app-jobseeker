<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:delete-unconfirmed-users')]
class DeleteUnconfirmedUsersCommand extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $threshold = new \DateTimeImmutable('-1 hour', new \DateTimeZone('UTC'));

        // Recherche des utilisateurs non confirmés créés avant le seuil
        $users = $this->userRepository->findUnconfirmedBefore($threshold);

        // Affichage des dates pour debug
        $output->writeln('Now UTC: ' . (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s'));
        $output->writeln('Threshold UTC: ' . $threshold->format('Y-m-d H:i:s'));
        $output->writeln('Users to delete: ' . count($users));

        foreach ($users as $user) {
            $createdAtUtc = $user->getCreatedAt()->setTimezone(new \DateTimeZone('UTC'));
            $output->writeln("Deleting user ID {$user->getId()} - created at " . $createdAtUtc->format('Y-m-d H:i:s'));
            $this->em->remove($user);
        }

        // Suppression effective en base
        $this->em->flush();

        $output->writeln('Deleted ' . count($users) . ' unconfirmed users.');

        return Command::SUCCESS;
    }
}
