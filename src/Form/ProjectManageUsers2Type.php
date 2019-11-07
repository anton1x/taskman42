<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use App\Hierarchy\ProjectRightsHierarchy;
use App\Repository\UserWorkspaceRightsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\OptionDefinitionException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class ProjectManageUsers2Type extends AbstractType
{

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', ChoiceType::class, [
            'multiple' => true,

        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }



}
