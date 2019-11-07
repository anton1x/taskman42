<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use App\Form\ProjectManageUsersType;
use App\Form\ProjectType;
use App\Hierarchy\ProjectRightsHierarchy;
use App\Repository\UserProjectRightRepository;
use App\Repository\UserWorkspaceRightsRepository;
use Doctrine\ORM\EntityManagerInterface;
use RightsHierarchy\Hierarchy;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProjectController extends AbstractController
{


    public function view()
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    public function remove()
    {
        
    }

    /**
     * @ParamConverter("workspace", options={"id" = "workspace_id"})
     */
    public function create(Workspace $workspace, Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(ProjectType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /**
             * @var Project $project
             */
            $project = $form->getData();
            $project->setWorkspace($workspace);
            $em->persist($project);
            $em->flush();

            $this->addFlash('success', 'Проект успешно создан');

            return $this->redirectToRoute('workspace_view', [
                'id' => $workspace->getId(),
            ]);
        }

        return $this->render('project/create.html.twig',
            [
                'workspace' => $workspace,
                'form' => $form->createView()
            ]);
    }

    /**
     * @ParamConverter("workspace", options={"id" = "workspace_id"})
     * @param Workspace $workspace
     * @param Project $project
     * @return Response
     */
    public function manageUsers(Workspace $workspace, Project $project, ProjectRightsHierarchy $hierarchy, Request $request)
    {

        $form = $this->createForm(ProjectManageUsersType::class, null, [
            'workspace' => $workspace,
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            dd($form->getData());
        }


        return $this->render('project/manage_users.html.twig', [
            'hierarchy' => $hierarchy->getHierarchy(),
            'form' => $form->createView(),
            'workspace' => $workspace,
            'project' => $project
        ]);
    }


    /**
     * @ParamConverter("workspace", options={"id" = "workspace_id"})
     * @param Workspace $workspace
     * @param Project $project
     * @return Response
     */
    public function manageUsersJSON(
        Workspace $workspace,
        Project $project,
        ProjectRightsHierarchy $hierarchy,
        UserWorkspaceRightsRepository $workspaceRightsRepository,
        UserProjectRightRepository $projectRightRepository,
        Request $request,
        SerializerInterface $serializer)
    {

        $workspace_rights = $workspaceRightsRepository->getWorkspaceRelatedUsers($workspace);
        $users_formatted = [];
        $assignedRights = $projectRightRepository->getRightsForProject($project);
        foreach ($workspace_rights as $right){
            $user = $right->getUser();
            $userId = $user->getId();
            $users_formatted[ $userId ] = [
                'id' => $userId,
                'name' => $user->getUsername(),
                'rights' => [] ,
            ];

            if(isset($assignedRights[$userId])){
                $users_formatted[ $userId ] ['rights'] = $assignedRights[$userId];
            }
        }

        $response = [
          'hierarchy' => $hierarchy->getHierarchy()->toArray(),
          'users' =>   $users_formatted
        ];

        $response = $serializer->serialize($response, 'json');

        return new JsonResponse($response, 200, [], true);
    }
}
