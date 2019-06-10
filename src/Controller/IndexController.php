<?php

namespace App\Controller;

use App\Repository\UserWorkspaceRightsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class IndexController extends AbstractController
{

    public function index(TokenStorageInterface $token, UserWorkspaceRightsRepository $rightsRepository)
    {

        $user = $token->getToken()->getUser();

        $relations = $rightsRepository->findBy([
            'user' => $user,
        ]);

        $workspaces = [];

        foreach ($relations as $relation) {
            $workspaces[] = $relation->getWorkspace();
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'workspaces' => $workspaces,
        ]);
    }
}
