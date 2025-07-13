<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CompanyUserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private CompanyRepository $companyRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['assignUserToCompany', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function assignUserToCompany(ViewEvent $event): void
    {
        $company = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$company instanceof Company || Request::METHOD_POST !== $method) {
            return;
        }

        $user = $this->security->getUser();

        if (null === $user) {
            throw new BadRequestHttpException('Utilisateur non connecté.');
        }

        // Vérifie si le user a déjà une Company
        $existingCompany = $this->companyRepository->findOneBy(['user' => $user]);

        if ($existingCompany) {
            throw new BadRequestHttpException('Ce compte a déjà une entreprise associée.');
        }

        // Associe le user à l'entreprise
        $company->setUser($user);
    }
}
