<?php

namespace App\Entity;

use App\Security\WorkspaceVoter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RightsHierarchy\Right;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProjectRightRepository")
 */
class UserProjectRight
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projectRights")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="userRelations")
     */
    private $project;

    /**
     * @var $right string
     * @ORM\Column(type="string", name="right", length=255)
     */
    private $right;


    public function __construct(User $user, Project $project, $right)
    {
        $this->user = $user;
        $this->project = $project;
        $this->right = $right;
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

    /**
     * @return string
     */
    public function getRight(): string
    {
        return $this->right;
    }

    /**
     * @param string $right
     */
    public function setRight($right)
    {
        $this->right = $right;
    }





}