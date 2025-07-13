<?php
namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Job;
use App\Repository\CompanyRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JobCompanySubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private CompanyRepository $companyRepository
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setCompanyForJob', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function setCompanyForJob(ViewEvent $event): void
    {
        $job = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$job instanceof Job || $method !== 'POST') {
            return;
        }

        $user = $this->security->getUser();

        if (!$user) {
            throw new \LogicException('User must be authenticated');
        }

        // Assuming a user has one company
        $company = $this->companyRepository->findOneBy(['user' => $user]);

        if (!$company) {
            throw new \LogicException('No company found for this employer');
        }

        $job->setCompany($company);
    }
}
