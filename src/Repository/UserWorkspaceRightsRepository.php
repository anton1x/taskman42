<?php
/**
 * Created by PhpStorm.
 * User: Anton1x
 * Date: 09.06.2019
 * Time: 20:50
 */

namespace App\Repository;


use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\User;

class UserWorkspaceRightsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserWorkspaceRights::class);
    }

    public function findOrCreateRelation(User $user, Workspace $workspace)
    {
        $relation = $this->findOneBy([
            'user' => $user,
            'workspace' => $workspace
        ]);
        

        return $relation ?: new UserWorkspaceRights($user, $workspace);
    }

    public function getUserRelatedWorkspaces(User $user)
    {
        $q = $this->createQueryBuilder('m')
            ->select(['m', 'workspace'])
            ->leftJoin('m.workspace', 'workspace', 'WITH', 'm.user = :user')
            ->setParameter('user', $user)
            ->getQuery();

        $result = $q->execute();

        return $result;
    }
}