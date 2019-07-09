<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Workspace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Predis\ClientInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyBundles\RedisBundle\Redis\Client;
use SymfonyBundles\RedisBundle\SymfonyBundlesRedisBundle;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{

    private $redis;

    /**
     * @var ContainerInterface|null
     */
    private $container;

    public function __construct(RegistryInterface $registry, ClientInterface $redis)
    {
        parent::__construct($registry, Project::class);
        $this->redis = $redis;
    }

    function getRedisKeyForProjectsList(Workspace $workspace)
    {
        return "workspace:{$workspace->getId()}:projects_list";
    }


    public function getProjectsByWorkspaceQuery(Workspace $workspace)
    {

        $q = $this->createQueryBuilder('m')
            ->where('m.workspace = :workspace')
            ->setParameter('workspace', $workspace);

        if($list = $this->redis->smembers($this->getRedisKeyForProjectsList($workspace))){
            $q->where('m.id IN (:ids) ')
                ->setParameters(['ids'=>$list]);
        }


        return $q->getQuery();
    }


    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
