<?php
/**
 * Created by PhpStorm.
 * User: Anton1x
 * Date: 09.06.2019
 * Time: 20:50
 */

namespace App\Repository;


use App\Entity\Project;
use App\Entity\UserProjectRight;
use App\Entity\UserProjectRights;
use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\User;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;

class UserProjectRightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProjectRights::class);
    }

    public function findOrCreateRelation(User $user, Project $project)
    {
        $relation = $this->findOneBy([
            'user' => $user,
            'project' => $project
        ]);
        

        return $relation ?: new UserWorkspaceRights($user, $project);
    }

    private function getRightsForProjectQuery(Project $project)
    {
        $items = $this->createQueryBuilder('m')
            ->where('m.project = :project')
            ->orderBy('m.user', 'asc')
            ->getQuery()
            ->setParameter('project', $project);
        return $items;
    }

    public function getRightsForProject($project)
    {
        $q = $this->getRightsForProjectQuery($project);
        $items = $q->getResult();
        $result = [];
        foreach ($items as $item){
            $result[ $item->getUser()->getId() ] = $item->getRights();
        }

        return $result;
    }

    /**
     * @param User $user
     * @param null|Workspace $workspace
     * @return mixed
     */
    public function getUserRelatedProjects(User $user, $workspace = null)
    {
        $q = $this->createQueryBuilder('m')
            ->select(['m', 'project'])
            ->innerJoin('m.project', 'project', 'WITH', 'm.user = :user')
            ->setParameter('user', $user);

        if($workspace){
            $q->innerJoin('m.project.workspace', 'workspace')
                ->where('workspace = :workspace')
                ->setParameter('workspace', $workspace);
        }

        $result = $q->getQuery()->execute();

        return $result;
    }
}