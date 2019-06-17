<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{

    public function index(Security $security)
    {
        /**
         * @var $user User
         */

        $user = $security->getUser();

        if(!$user){
            throw new AccessDeniedException();
        }

        //$user = $token->getToken()->getUser();

        $relations = $user->getMappedRights();


        $workspaces = [];

        foreach ($relations as $relation){
            $workspaces[] = $relation->getWorkspace();
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'workspaces' => $workspaces,
        ]);
    }
}
