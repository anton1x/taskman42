<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="UserWorkspaceRights", mappedBy="user", fetch="LAZY", indexBy="user.id")
     * @ORM\JoinColumns({
     *          @ORM\JoinColumn(name="id"),
     *          @ORM\JoinColumn(name="name"),
     *          @ORM\JoinColumn(name="description")
     *     })
     */
    private $workspaceRights;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProjectRights", mappedBy="user",fetch="LAZY", indexBy="user.id")
     *      * @ORM\JoinColumns({
     *          @ORM\JoinColumn(name="id"),
     *          @ORM\JoinColumn(name="project"),
     *          @ORM\JoinColumn(name="rights")
     *     })
     */

    private $projectRights;


    /**
     * @return UserProjectRights
     */
    public function getProjectRights()
    {
        return $this->projectRights;
    }



    /**
     * @return mixed
     */
    public function getWorkspaceRights()
    {
        return $this->workspaceRights;
    }

    public function getMappedRights()
    {
        $result = [];
        /**
         * @var $relation UserWorkspaceRights
         */
        foreach ($this->getWorkspaceRights() as $relation){
            $result[ $relation->getWorkspace()->getId() ] = $relation;
        }

        return $result;
    }


    public function __construct()
    {
        parent::__construct();
        $this->workspaceRights = new ArrayCollection();
        $this->projectRights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}
