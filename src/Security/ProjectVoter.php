<?php
/**
 * Created by PhpStorm.
 * User: Anton1x
 * Date: 09.06.2019
 * Time: 19:21
 */

namespace App\Security;


use App\Entity\Project;
use App\Entity\UserProjectRight;
use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use App\Hierarchy\ProjectRightsHierarchy;
use App\Repository\UserProjectRightRepository;
use App\Repository\UserWorkspaceRightsRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{

    /**
     * @var UserWorkspaceRightsRepository
     */
    private $rightsRepository;

    /**
     * @var ProjectRightsHierarchy
     */
    private $rightsHierarchy;

    public function __construct(UserProjectRightRepository $rightsRepository, ProjectRightsHierarchy $rightsHierarchy)
    {
        $this->rightsRepository = $rightsRepository;
        $this->rightsHierarchy = $rightsHierarchy;
    }

    protected function supports($attribute, $subject)
    {
        if(!$this->rightsHierarchy->getItem($attribute)){
            return false;
        }

        if(!($subject instanceof Project)){
            return false;
        }

        return true;
    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        $rights = $user->getMappedRights();

        if(
            isset($rights[$subject->getId()]) &&
            $rights[$subject->getId()]->hasRight($attribute)){
            return true;
        }

        return false;

    }
}