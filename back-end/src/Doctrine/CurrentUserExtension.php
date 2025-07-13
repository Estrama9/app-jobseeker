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

        $joins = array_map(fn($join) => $join->getAlias(), $queryBuilder->getDQLPart('join')[$rootAlias] ?? []);

        if ($this->security->isGranted("ROLE_EMPLOYER") && !in_array('c', $joins)) {
            $queryBuilder
                ->leftJoin("$rootAlias.company", 'c')   // job -> company
                ->leftJoin('c.user', 'u')               // company -> user
                ->andWhere('u.id = :current_user')
                ->setParameter('current_user', $user->getId());

            return;
        }

        if ($this->security->isGranted("ROLE_CANDIDATE") && !in_array('cand', $joins)) {
            $queryBuilder
                ->leftJoin("$rootAlias.candidate", 'cand')
                ->leftJoin('cand.user', 'u')
                ->andWhere('u.id = :current_user')
                ->setParameter('current_user', $user->getId());

            return;
        }

        if ($this->security->isGranted("ROLE_EMPLOYER") && !in_array('j', $joins)) {
            $queryBuilder
                ->leftJoin("$rootAlias.job", 'j')
                ->leftJoin('j.company', 'c')
                ->leftJoin('c.user', 'u')
                ->andWhere('u.id = :current_user')
                ->setParameter('current_user', $user->getId());

            return;
        }

        throw new AccessDeniedException();

    }

}
