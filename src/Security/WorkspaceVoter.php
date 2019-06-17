<?php
/**
 * Created by PhpStorm.
 * User: Anton1x
 * Date: 09.06.2019
 * Time: 19:21
 */

namespace App\Security;


use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use App\Repository\UserWorkspaceRightsRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WorkspaceVoter extends Voter
{

    /**
     * @var UserWorkspaceRightsRepository
     */
    private $rightsRepository;

    public $aa = 'aa';

    public function __construct(UserWorkspaceRightsRepository $rightsRepository)
    {
        $this->rightsRepository = $rightsRepository;
    }

    protected function supports($attribute, $subject)
    {
        if(!in_array($attribute, UserWorkspaceRights::permissions)){
            return false;
        }

        if(!($subject instanceof Workspace)){
            return false;
        }

        return true;
    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        $workspace = $subject;

        $rights = $user->getMappedRights();

        if(
            isset($rights[$workspace->getId()]) &&
            $rights[$workspace->getId()]->hasRight($attribute)){
            return true;
        }

        return false;

    }
}