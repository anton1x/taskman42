<?php

namespace App\Controller;

use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class WorkspaceController extends AbstractController
{

    public function view(Workspace $workspace)
    {
        return $this->render('workspace/index.html.twig', [
            'workspace' => $workspace
        ]);
    }


    /**
     * @param Workspace $workspace
     * @param RouterInterface $router
     * @return Response
     */
    public function remove(Workspace $workspace, RouterInterface $router, \Symfony\Component\Security\Core\Security $security, FlashBagInterface $flashBag)
    {

        if(!$security->isGranted(UserWorkspaceRights::permissions['delete'], $workspace)){
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($workspace);
        $em->flush();

        $this->addFlash(
            'success',
            sprintf("Рабочая область \"%s\" успешно удалена", $workspace->getName())
            );

        return new RedirectResponse($router->generate('index_index'));
    }
}
