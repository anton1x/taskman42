<?php

namespace App\Entity;

use App\Security\WorkspaceVoter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserWorkspace
 * @ORM\Entity(repositoryClass="App\Repository\UserWorkspaceRightsRepository")
 */
class UserWorkspaceRights
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="workspaceRights")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Workspace")
     */
    private $workspace;

    /**
     * @var $rights ArrayCollection
     * @ORM\Column(type="array", name="rights")
     */
    private $rights;

    public const permissions = [
      'delete' => 'CAN_DELETE',
      'view' => 'CAN_VIEW',
      'start_project' => 'CAN_START_PROJECT',
    ];

    public function __construct(User $user, Workspace $workspace)
    {
        $this->rights = new ArrayCollection();
        $this->user = $user;
        $this->workspace = $workspace;


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
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * @param mixed $workspace
     */
    public function setWorkspace(Workspace $workspace)
    {
        $this->workspace = $workspace;
    }

    public function hasRight($right)
    {
        return $this->rights->contains($right);
    }

    public function addRight($right)
    {
        if(!$this->hasRight($right) && in_array($right, self::permissions)){
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