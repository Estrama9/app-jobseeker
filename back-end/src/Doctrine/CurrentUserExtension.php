<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    public function __construct(
        private Security $security,
    )
    {
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    // private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    // {
    //     $implements = class_implements($resourceClass, false);
    //     if (!$implements) {
    //         return;
    //     }

    //     if (!array_key_exists(OwnerableInterface::class, $implements)) {
    //         return;
    //     }
    //     if($this->security->isGranted("ROLE_ADMIN")) {
    //         return;
    //     }

    //     $user = $this->security->getUser();
    //     if (!$user instanceof User) {
    //         throw new AccessDeniedException();
    //     }

    //     $rootAlias = $queryBuilder->getRootAliases()[0];
    //     $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
    //     $queryBuilder->setParameter('current_user', $user->getId());
    // }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
{
    $implements = class_implements($resourceClass, false);
    if (!$implements || !array_key_exists(OwnerableInterface::class, $implements)) {
        return;
    }

    if ($this->security->isGranted("ROLE_ADMIN")) {
        return;
    }

    $user = $this->security->getUser();
    if (!$user instanceof User) {
        throw new AccessDeniedException();
    }

    $rootAlias = $queryBuilder->getRootAliases()[0];

    // Join from application -> job -> company -> user
    $queryBuilder
        ->join("$rootAlias.job", 'j')
        ->join('j.company', 'c')
        ->join('c.user', 'u')
        ->andWhere('u.id = :current_user')
        ->setParameter('current_user', $user->getId());
}

}
