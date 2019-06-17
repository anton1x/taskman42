<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\WorkspaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class IndexController extends AbstractController
{

    /**
     * @IsGranted("ROLE_USER")
     */
    public function index(Security $security, WorkspaceRepository $workspaceRepository)
    {
        /**
         * @var $user User
         */

        $user = $security->getUser();



        $relations = $user->getMappedRights();
        //dd($relations);



        $workspaces = $workspaceRepository->findBy(
            [
                'id' => array_keys($relations)
            ]
        );


        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'workspaces' => $workspaces,
        ]);
    }
}
