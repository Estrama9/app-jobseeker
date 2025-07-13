<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CandidateUserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private CandidateRepository $candidateRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['assignUserToCandidate', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function assignUserToCandidate(ViewEvent $event): void
    {
        $candidate = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$candidate instanceof Candidate || Request::METHOD_POST !== $method) {
            return;
        }

        $user = $this->security->getUser();

        if (null === $user) {
            throw new BadRequestHttpException('Utilisateur non connecté.');
        }

        // Vérifie si le user a déjà un Candidate
        $existingCandidate = $this->candidateRepository->findOneBy(['user' => $user]);

        if ($existingCandidate) {
            throw new BadRequestHttpException('Ce compte a déjà un candidat associé.');
        }

        // Associe le user au candidate (sera flush automatiquement)
        $candidate->setUser($user);
    }
}
