<?php

namespace App\Entity;

use App\Security\WorkspaceVoter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProjectRightRepository")
 */
class UserProjectRights
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="User",  inversedBy="workspaceRights")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", cascade={"remove"}, inversedBy="userRelations")
     */
    private $project;

    /**
     * @var $rights ArrayCollection
     * @ORM\Column(type="array", name="rights")
     */
    private $rights;



    public function __construct(User $user, Project $project)
    {
        $this->rights = new ArrayCollection();
        $this->user = $user;
        $this->project = $project;


    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    public function hasRight($right)
    {
        return $this->rights->contains($right);
    }

    public function addRight($right)
    {
        if(!$this->hasRight($right)){
            $this->rights->add($right);
        }
    }

    public function removeRight($right)
    {
        if($this->hasRight($right)){
            $this->rights->removeElement($right);
        }
    }

    /*
    public function setRights(array $rights)
    {
        $this->rights = $rights;
    }*/

    /**
     * @return ArrayCollection
     */
    public function getRights(): ArrayCollection
    {
        return $this->rights;
    }


}