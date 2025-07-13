<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Application;
use App\Repository\CandidateRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApplicationCandidateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private CandidateRepository $candidateRepository
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setCandidateForApplication', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function setCandidateForApplication(ViewEvent $event): void
    {
        $application = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$application instanceof Application || $method !== 'POST') {
            return;
        }

        $user = $this->security->getUser();

        if (!$user) {
            throw new \LogicException('User must be authenticated');
        }

        $candidate = $this->candidateRepository->findOneBy(['user' => $user]);

        if (!$candidate) {
            throw new \LogicException('No candidate profile found for this user.');
        }

        $application->setCandidate($candidate);

        if (!$application->getJob()) {
            throw new \LogicException('Job must be set in the application.');
        }
    }
}
