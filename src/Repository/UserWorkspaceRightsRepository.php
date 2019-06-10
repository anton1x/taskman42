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
use FOS\UserBundle\Model\User;

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
}